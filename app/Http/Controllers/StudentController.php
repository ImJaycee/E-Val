<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\InstructorAccount;
use App\Models\StudentAccount;
use App\Models\StudentsTokenAccounts;
use App\Models\SubjectEnrolled;
use App\Models\SubjectAssigned;
use App\Models\StudentEvaluation;
use App\Models\UsersFeedback;
use App\Models\EvaluationStatus;
use App\Models\EnrolledStudents;
use App\Models\Subject;
use Carbon\Translator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
Use Sentiment\Analyzer;
use App\Helpers\TranslateTextHelper;


class StudentController extends Controller
{
    // 

    public function Student_loginprocess(Request $request){
        // Validate the input
        $validated = $request->validate([
            'eval_token' => ['required'],
        ]);
    
        // Retrieve the token from the request
        $token = $request->input('eval_token');
        
    
        // Attempt to find a student with the provided token
        $student = StudentsTokenAccounts::where('eval_token', $token)->first();
    
        if ($student) {
            // Manually log the student in
            Auth::guard('students')->login($student);
    
            // Regenerate the session to prevent fixation
            $request->session()->regenerate();
            $evaluation_status = EvaluationStatus::first();
            // Store the token and student ID in the session
            session([
                'eval_token' => $student->eval_token,
                'student_id' => $student->student_id,
                'eval_status' => $evaluation_status->eval_status,
            ]);
    
            // // Debugging: Check session data
            // \Log::info('Student logged in: ' . $student->student_id);
            // \Log::info('Session data: ' . print_r(session()->all(), true));
    
            // Redirect or proceed with the rest of your logic
            return redirect()->route('student.evaluation', ['eval_token' => $student->eval_token])->with('message', 'Welcome!');
        } else {
            // Log the failure for debugging
            // \Log::info('Authentication failed for token: ' . $token);
    
            // Handle login failure
            return back()->withErrors([
                'invalid' => 'Invalid Token.',
            ])->withInput();
        }
    }



    // public function Student_loginprocess(Request $request){ // login process
    //     $validated = $request->validate([
    //         // "student_id" => ['required', 'min:9','numeric'],
    //         // "password" => ['required', 'min:8'],
    //         "eval_token" => ['required'],
    //     ]);
       
    //     if(auth()->guard('students')->attempt($validated)){ //login successful
    //         $request->session()->regenerate(); //create session
            
    //         $student = auth()->guard('students')->user();
    //         $student_id = $student->student_id;
    //         // session(['student_id' => $student->student_id, 'pfp' => $student->pfp]);
    //         // session(['student_id' => $student->student_id, 
    //         //          'firstname' => $student->firstname,
    //         //          'pfp' => $student->pfp, ]);
    //         session(['eval_token' => $student->eval_token, 
    //                  'student_id' => $student->student_id,]);
    //         dd(session());
    //         return redirect()->route('student.evaluation', ['eval_token' => $student->eval_token])->with('message', 'Welcome!');//return redirect to dashboard
        
    //                 // return redirect()->route('student.dashboard', ['student_id' => $student_id])->with('message', 'Welcome back!');//return redirect to dashboard
    //     }else {
    //         // Log the input for debugging purposes
    //         return redirect("/")->with('message', 'Invalid Credentials!');//return redirect to dashboard
          
    //     }   

    //     return back()->withErrors([ //login failed
    //         'student_id' => 'Invalid Credentials'
    //     ])->withInput(); //return back to login page
    // }


    public function logout(Request $request){//logout
        auth()->guard('students')->logout(); 
        $request->session()->invalidate(); //invalidate session
        $request->session()->regenerateToken(); //regenerate token
        return redirect('/')
        ->with('message', 'Logged out')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
    }
    public function logout_inactive(){//logout
        auth()->guard('students')->logout(); 
        session()->invalidate(); //invalidate session
        session()->regenerateToken(); //regenerate token
        return redirect('/')
        ->with('message', 'Logged out')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
    }

    //evaluation side
    public function Student_evaluation($eval_token) {
        // Retrieve the student account using the eval_token
        $student = StudentsTokenAccounts::where('eval_token', $eval_token)->firstOrFail();
    
        // Get the student's subjects from the student account
        $studentSubjects = [
            $student->subject1,
            $student->subject2,
            $student->subject3,
            $student->subject4,
            $student->subject5,
            $student->subject6,
            $student->subject7,
            $student->subject8,
            $student->subject9,
            $student->subject10
        ];

    
        $allSubjectsEnrolled = [];
    
        // Loop through each subject to get the assigned instructor
        foreach ($studentSubjects as $subjectCodes) {
            // Split the subject code and section
            $subjectCode = substr($subjectCodes, 0, 7); // Assuming the subject code is always 3 characters
            $section = substr($subjectCodes, 8); // Assuming the section starts after the subject code
        
            //dd($subjectCode, $section);
            // Skip if the subject code is null or empty
            if (empty($subjectCodes)) {
                continue;
            }
    
            $assignedInstructor = SubjectAssigned::where('subject_code', $subjectCode)
                ->where('section', $section)
                ->first();
    
            if ($assignedInstructor) {
                $InstructorPFP = InstructorAccount::where('instructor_id', $assignedInstructor->instructor_id)->first();
                
                $status = StudentEvaluation::where('instructor_id', $assignedInstructor->instructor_id)
                    ->where('eval_token', $student->eval_token)
                    ->where('subject_code', $subjectCode)
                    ->exists();
    
                // Combine the subject and instructor data
                $allSubjectsEnrolled[] = [
                    'instructor_id' => $assignedInstructor->instructor_id,
                    'subject_code' => $subjectCode,
                    //'section' => $section,
                    'pfp' => $InstructorPFP ? $InstructorPFP->pfp : null,
                    'instructor_name' => $assignedInstructor->instructor_name,
                    'status' => $status ? 'Submitted' : 'Not submitted',
                ];
            } else {
                // If no instructor is assigned, add the subject with default values
                $allSubjectsEnrolled[] = [
                    'instructor_id' => null,
                    'subject_code' => $subjectCode,
                    //'section' => $section,
                    'pfp' => null,
                    'instructor_name' => 'Not assigned',
                ];
            }
        }

        // dd($allSubjectsEnrolled);
    
        return view('student-side.student-evaluation', compact('student', 'allSubjectsEnrolled'));
    }

    public function StudentEvaluationProcess(Request $request,){
       
          $validated = $request->validate([
              'instructor_id' => ['required', 'string'],
              'eval_token' => ['required', 'string'],
              'subject_code' => ['required', 'string'],
              //'section' => ['required', 'string'],
              'semester' => ['required', 'string'],
              'A_Y' => ['required', 'string'],
              'I-1' => ['required', 'string'],
              'I-2' => ['required', 'string'],
              'I-3' => ['required', 'string'],
              'II-1' => ['required', 'string'],
              'II-2' => ['required', 'string'],
              'II-3' => ['required', 'string'],
              'II-4' => ['required', 'string'],
              'III-1' => ['required', 'string'],
              'III-2' => ['required', 'string'],
              'IV-1' => ['required', 'string'],
              'IV-2' => ['required', 'string'],
              'V-1' => ['required', 'string'],
              'V-2' => ['required', 'string'],
              'V-3' => ['required', 'string'],
              'comments' => ['required', 'string'],
          ]);
          
        $comments = $request->input('comments');
        $analyzer = new Analyzer(); // the analyzer
        // Set the source and target languages
        TranslateTextHelper::setSource('fil')->setTarget('en');

        // Translate the text
        $translatedComment = TranslateTextHelper::translate($comments);

        $sentiment = $analyzer->getSentiment($translatedComment); // get the sentiment of the comments
        $compound = $sentiment['compound']; // Get the compound score from the sentiment

        $threshold = 0; // Set your threshold value here
        
        if ($compound > $threshold) {
            $sentimentLabel = 'Best';
        } elseif ($compound < $threshold) {
            $sentimentLabel = 'Good';
        } else {
            $sentimentLabel = 'Better';
        }
        $validated['sentiment'] = $sentimentLabel;

        $totalScore = $validated['I-1'] + $validated['I-2'] + $validated['I-3'] + $validated['II-1'] + $validated['II-2'] + $validated['II-3'] + $validated['II-4'] + $validated['III-1'] + $validated['III-2'] + $validated['IV-1'] + $validated['IV-2'] + $validated['V-1'] + $validated['V-2'] + $validated['V-3'];
       
        $I_Total = $validated['I-1'] + $validated['I-2'] + $validated['I-3'];
        $II_Total = $validated['II-1'] + $validated['II-2'] + $validated['II-3'] + $validated['II-4'];
        $III_Total = $validated['III-1'] + $validated['III-2'];
        $IV_Total = $validated['IV-1'] + $validated['IV-2'];
        $V_Total = $validated['V-1'] + $validated['V-2'] + $validated['V-3'];

        $validated['I_Total'] = $I_Total;
        $validated['II_Total'] = $II_Total;
        $validated['III_Total'] = $III_Total;
        $validated['IV_Total'] = $IV_Total;
        $validated['V_Total'] = $V_Total;
        $validated['total_score'] = $totalScore;
        
        //dd($validated);
        $evaluationStatus = StudentEvaluation::where('instructor_id', $validated['instructor_id'])
        ->where('eval_token', $validated['eval_token'])
        ->where('subject_code', $validated['subject_code'])
        //->where('section', $validated['section'])
        ->where('A_Y', $validated['A_Y'])
        ->exists();

        if ($evaluationStatus)
        {
            return back()->with('message', 'Evaluation submitted already!')->with('reload', true);
        }

        $studentEvaluation = StudentEvaluation::create($validated);
        if ($studentEvaluation) {
            return redirect()->route('student.evaluation', ['eval_token' => $validated['eval_token']])->with('message', 'Evaluation Submitted!');
            //return redirect()->route('student.evaluation', ['student_id' => $validated['student_id']])->with('message', 'Evaluation submitted successfully!')->with('reload', true);
        } else {
            return back()->with('message', 'Evaluation submitted already!')->with('reload', true);
        }
        
    }



    // Student Feedback Side -----------------------------
    public function SubmitFeedback(Request $request){ // student feedback side
        $validated = $request->validate([
            'users_id' => ['required', 'string'],
            'current_date' => ['required', 'date'],
            'rating' => ['required', 'integer'],
            'comment' => ['required', 'string'],
        ]);
        //dd($validated);

        // Additional validation logic to check if the created_at timestamp is older than a month
        $userFeedback = UsersFeedback::where('users_id', $validated['users_id'])
        ->orderBy('created_at', 'desc')
        ->first();

        if ($userFeedback) {
            $currentDate = date_create($validated['current_date']);
            $lastFeedbackDate = date_create($userFeedback->created_at);
            $interval = date_diff($lastFeedbackDate, $currentDate);
            $days = $interval->format('%a');

            if ($days < 30) {
                return back()->with('message', 'Feedback can only be submitted once a month.');
            }
        }


        $feedback = UsersFeedback::create($validated);
        if ($feedback) {
            return back()->with('message', 'Feedback submitted successfully, Thank you!');
        } else {
            return back()->with('message', 'Failed to submit feedback!');
        }
        

    }

        
}
