<?php

namespace App\Http\Controllers;

use App\Models\InstructorAccount;
use App\Models\StudentAccount;
use App\Models\SubjectEnrolled;
use App\Models\SubjectAssigned;
use App\Models\StudentEvaluation;
use App\Models\UsersFeedback;
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
    public function registerStudent(Request $request){

        $validated = $request->validate([
            "student_id" => ['required', 'unique:student_accounts'],
            'contact' => ['required', 'digits:11'],
            "firstname" => ['required', 'string', 'min:2'],
            "middlename" => ['required', 'string', 'min:2'],
            "lastname" => ['required', 'string', 'min:2'],
            "email" => ['required', 'email', 'unique:student_accounts'],
            "program" => ['required', 'string'],
            "password" => ['required', 'string', 'min:8', 'confirmed'],
        ]);
               

        //  dd($validated);
        $validated['password'] = bcrypt($validated['password']); //validate password and bcrypt password
         // Check if the email and ID already exists
         $existingStudent = StudentAccount::where('student_id', $validated['student_id'])
         ->orWhere('email', $validated['email'])->first();

        if ($existingStudent) {
            return redirect('/')->with('message', 'Account already exists');
        }
        if ($studentAccount = StudentAccount::create($validated)) {
            return redirect('/')->with('message', 'Account created successfully');
        } else {
            return redirect('/')->with('error', 'Failed to create account');
        }
    }

    public function Student_loginprocess(Request $request){ // login process
        $validated = $request->validate([
            "student_id" => ['required', 'min:3','numeric'],
            "password" => ['required', 'min:8'],
        ]);
        if(auth()->guard('students')->attempt($validated)){ //login successful
            $request->session()->regenerate(); //create session
            
            $student = auth()->guard('students')->user();
            $student_id = $student->student_id;
            // session(['student_id' => $student->student_id, 'pfp' => $student->pfp]);
            session(['student_id' => $student->student_id, 
                     'firstname' => $student->firstname,
                     'pfp' => $student->pfp, ]);
            
                     return redirect()->route('student.dashboard', ['student_id' => $student_id])->with('message', 'Welcome back!');//return redirect to dashboard
        }else {
            // Log the input for debugging purposes
            return redirect("/")->with('message', 'Invalid Credentials!');//return redirect to dashboard
          
        }   

        return back()->withErrors([ //login failed
            'student_id' => 'Invalid Credentials'
        ])->withInput(); //return back to login page
    }

    public function Student_dashboard($student_id){
        // Get the student details
        $student = StudentAccount::where('student_id', $student_id)->first();

        // Get the subjects enrolled by the student
        $studentSubjects = SubjectEnrolled::where('student_id', $student_id)->get();

        // Initialize an empty array to store the combined data
        $allSubjectsEnrolled = [];

        // Loop through each enrolled subject to get the assigned instructor
         foreach ($studentSubjects as $subject) {
            $subjectDescription = Subject::where('subject_code', $subject->subject_code)->first();
           $assignedInstructor = SubjectAssigned::where('subject_code', $subject->subject_code)
         ->where('section', $subject->section)
         ->first();

            
        //     // Combine the subject and instructor data
        $allSubjectsEnrolled[] = [

             'subject_code' => $subject->subject_code,
            'description' => $subjectDescription->description,
            'instructor_name' => $assignedInstructor ? $assignedInstructor->instructor_name : 'Not assigned',

            ];
            
         }

        // Pass the student details and combined data to the view
        //return view('student-side.student-dashboard', compact('student'));
         return view('student-side.student-dashboard', compact('student', 'allSubjectsEnrolled'));
    }


    public function logout(Request $request){//logout
        auth()->guard('students')->logout(); 
        $request->session()->invalidate(); //invalidate session
        $request->session()->regenerateToken(); //regenerate token
        return redirect('/')
        ->with('message', 'Logged out')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
    }

    public function AddSubject(Request $request, $student_id){ //add subject
        $validated = $request->validate([
            'student_id' => ['required'],
            'program' => ['required', 'string'],
            'subject_code' => ['required', 'string'],
            'year' => ['required', 'string'],
            'section' => ['required', 'string'],
            'semester' => ['required', 'string'],
            'A_Y' => ['required', 'string'],
        ]);        
        //dd($validated);

        $student = StudentAccount::where('student_id', $student_id)->first();
        $subject = SubjectEnrolled::where('subject_code', $validated['subject_code'])
        ->where('student_id', $student_id)
        ->where('A_Y', $validated['A_Y'])
        ->first();
    
        if ($subject) {
            //return redirect()->route('student.dashboard', ['student_id' => $student_id])->with('message', 'Subject added already!')->with('reload', true);
            return back()->with('message', 'Subject added already!');
        }

        $section = $validated['program'] ." ". $validated['year'] . $validated['section'];

        $subjectEnrolled = SubjectEnrolled::create([
            'student_id' => $student_id,
            'subject_code' => $validated['subject_code'],
            'section' => $section,
            'semester' => $validated['semester'],
            'A_Y' => $validated['A_Y'],
        ]);



        if ($subjectEnrolled) {
            return redirect()->route('student.dashboard', ['student_id' => $student_id])->with('message', 'Subject added successfully!')->with('reload', true);
           
        } else {
            return redirect()->route('student.dashboard', ['student_id' => $student_id])->with('message', 'Failed to add subject!')->with('reload', true);
        }
    }

    public function RemoveSubject($student_id, $subject_code){ //remove subject
        $subject = SubjectEnrolled::where('student_id', $student_id)
        ->where('subject_code', $subject_code)
        ->first();
        //dd($subject);
    
        if ($subject) {
            $subject->delete();
            return redirect()->route('student.dashboard', ['student_id' => $student_id])->with('message', 'Subject removed successfully!')->with('reload', true);
        } else {
            return redirect()->route('student.dashboard', ['student_id' => $student_id])->with('message', 'Failed to remove subject!')->with('reload', true);
        }
    }
    

    public function updateProfilePage($student_id){ //update profile page
        $student = StudentAccount::where('student_id', $student_id)->first();
        return view('student-side.student-profile', compact('student'));
    }

    public function updateProfileForm($student_id){ //update profile form
        $student = StudentAccount::where('student_id', $student_id)->first();
        return view('student-side.update-profile', compact('student'));
    }

    public function updateProfile(Request $request, $student_id){    //update profile
        $validated = $request->validate([
            'contact' => ['required', 'digits:11'],
            "firstname" => ['required', 'string', 'min:2'],
            "middlename" => ['required', 'string', 'min:2'],
            "lastname" => ['required', 'string', 'min:2'],
            "email" => ['required', 'email','unique:student_accounts,email,'.$student_id.',student_id'],
            "program" => ['required', 'string'],
            "year" => ['required', 'string'],
            "section" => ['required', 'string'],
            "pfp" => ['image', 'mimes:jpeg,png,jpg', 'nullable'],
        ]);
        //dd($validated);
       
        $student = StudentAccount::where('student_id', $student_id)->first();

        if (!$student) {
            return redirect()->route('student.profile', ['student_id' => $student_id])->with('message', 'Failed!')->with('reload', true);
        }
        
        try {
            $path = null;
        
            if (isset($validated['pfp']) && $validated['pfp'] != null) {
                $fileName = $request->file('pfp');
                $path = $request->file('pfp')->store('public/images/pfp');
                $validated['pfp'] = $fileName->hashName();
            }
        
            $student->update($validated);
            session(['student_id' => $student->student_id, 
                     'pfp' => $student->pfp, ]);
            
                     return redirect()->route('student.profile', ['student_id' => $student_id])->with('message', 'Updated Successfully!')->with('reload', true);
        
        } catch (\Exception $e) {
            if ($path !== null) {
                Storage::delete($path);
            }
            return redirect('/student-profile')->with('message', 'Profile update failed')->with('reload', true);
        }
        
    }

    
    public function changePassword(Request $request, $student_id) { //change password
        $validated = $request->validate([
            "oldpassword" => ['required',],
            "newpassword" => ['required'],
            "con_pass" => ['required'],
        ]);
        if(strlen($request->input('newpassword')) < 8 ){
            return redirect()->route('student.profile', ['student_id' => $student_id])->with('message', 'Password must be at least 8 characters long');
        }
        

        if($request->input('newpassword') !== $request->input('con_pass')){
            return redirect()->route('student.profile', ['student_id' => $student_id])->with('message', 'Passwords do not match!');
        }
    
        // Find the student by ID
        $student = StudentAccount::where('student_id', $student_id)->firstOrFail();
    
        // Check if the old password matches the one stored in the database
        if (password_verify($request->input('oldpassword'), $student->password)) {
            // Hash the new password before updating the database
            $hashedPassword = bcrypt($request->input('newpassword'));
    
            // Update the password
            $student->password = $hashedPassword;
            $student->save();
    
            // Redirect with success message
            return redirect()->route('student.profile', ['student_id' => $student_id])->with('message', 'Password changed!');
        } else {
            // Redirect with error message
            return redirect()->route('student.profile', ['student_id' => $student_id])->with('message', 'Incorrect Password!');
        }
    }


    // Evaluation Side -----------------------------
    public function Student_evaluation($student_id){ // student evaluation side

        $student = StudentAccount::where('student_id', $student_id)->first();

        $studentSubjects = SubjectEnrolled::where('student_id', $student_id)->get();
        $allSubjectsEnrolled = [];
    
        // Loop through each enrolled subject to get the assigned instructor
        foreach ($studentSubjects as $subject) {
            $assignedInstructor = SubjectAssigned::where('subject_code', $subject->subject_code)
                ->where('section', $subject->section)
                ->first();
    
            if ($assignedInstructor) {
                $InstructorPFP = InstructorAccount::where('instructor_id', $assignedInstructor->instructor_id)->first();

                $status = StudentEvaluation::where('instructor_id', $assignedInstructor->instructor_id)
                ->where('student_id', $student_id)
                ->where('subject_code', $subject->subject_code)
                ->where('section', $subject->section)
                ->where('A_Y', $subject->A_Y);
    
                // Combine the subject and instructor data
                $allSubjectsEnrolled[] = [
                    'instructor_id' => $assignedInstructor->instructor_id,
                    'subject_code' => $subject->subject_code,
                    'pfp' => $InstructorPFP ? $InstructorPFP->pfp : null,
                    'instructor_name' => $assignedInstructor->instructor_name,
                    'status' => $status->exists() ? 'Submitted' : 'Not submitted',

                ];
            } else {
                // If no instructor is assigned, add the subject with default values
                $allSubjectsEnrolled[] = [
                    'instructor_id' => null,
                    'subject_code' => $subject->subject_code,
                    'pfp' => null,
                    'instructor_name' => 'Not assigned',
                ];
            }
            
        }
    
        return view('student-side.student-evaluation', compact('student','allSubjectsEnrolled'));
    }

    public function StudentEvaluationProcess(Request $request,){
       
          $validated = $request->validate([
              'instructor_id' => ['required', 'string'],
              'student_id' => ['required', 'string'],
              'subject_code' => ['required', 'string'],
              'section' => ['required', 'string'],
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
            $sentimentLabel = 'Positive';
        } elseif ($compound < $threshold) {
            $sentimentLabel = 'Negative';
        } else {
            $sentimentLabel = 'Neutral';
        }
        $validated['sentiment'] = $sentimentLabel;

        $totalScore = $validated['I-1'] + $validated['I-2'] + $validated['I-3'] + $validated['II-1'] + $validated['II-2'] + $validated['II-3'] + $validated['II-4'] + $validated['III-1'] + $validated['III-2'] + $validated['IV-1'] + $validated['IV-2'] + $validated['V-1'] + $validated['V-2'] + $validated['V-3'];
        $validated['total_score'] = $totalScore;
        //dd($validated);
        $evaluationStatus = StudentEvaluation::where('instructor_id', $validated['instructor_id'])
        ->where('student_id', $validated['student_id'])
        ->where('subject_code', $validated['subject_code'])
        ->where('section', $validated['section'])
        ->where('A_Y', $validated['A_Y'])
        ->exists();

        if ($evaluationStatus)
        {
            return back()->with('message', 'Evaluation submitted already!')->with('reload', true);
        }

        $studentEvaluation = StudentEvaluation::create($validated);
        if ($studentEvaluation) {
            return redirect()->route('student.evaluation', ['student_id' => $validated['student_id']])->with('message', 'Evaluation submitted successfully!')->with('reload', true);
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
