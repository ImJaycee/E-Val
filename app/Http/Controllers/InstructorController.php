<?php

namespace App\Http\Controllers;

use App\Models\InstructorAccount;
use App\Models\SubjectAssigned;
use App\Models\DlcInstructors;
use App\Models\StudentEvaluation;
use App\Models\PeerToPeer;
use App\Models\Subject;
use App\Models\FilterWords;
use App\Models\UsersFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
Use Sentiment\Analyzer;
use App\Helpers\TranslateTextHelper;
use App\Models\PeerEvaluation;
use App\Models\EvaluationStatus;

class InstructorController extends Controller
{
    //
    public function registerInstructor(Request $request){ // register
 
        $validated = $request->validate([
            "instructor_id" => ['required', 'unique:instructor_accounts'],
            'contact' => ['required', 'digits:11'],
            "firstname" => ['required', 'string', 'min:2'],
            "middlename" => ['required', 'string', 'min:2'],
            "lastname" => ['required', 'string', 'min:2'],
            "email" => ['required', 'email', 'unique:instructor_accounts'],
            "sex" => ['required', 'string'],
            "department" => ['required', 'string'],
            "password" => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $dlcInstructor = DlcInstructors::where('instructor_id', $validated['instructor_id'])->first();

        if (!$dlcInstructor) {
            return redirect('/')->with('message', 'Invalid ID');
        }
            
        
        $validated['password'] = bcrypt($validated['password']); //validate password and bcrypt password
         // Check if the email and ID already exists
         $existingStudent = InstructorAccount::where('instructor_id', $validated['instructor_id'])
         ->orWhere('email', $validated['email'])->first();

        if ($existingStudent) {
            return redirect('/')->with('message', 'Account already exists');
        }
        if ($studentAccount = InstructorAccount::create($validated)) {
            return redirect('/')->with('message', 'Account created successfully');
        } else {
            return redirect('/')->with('error', 'Failed to create account');
        }
    } //end of registration

    public function Instructor_loginprocess(Request $request){ // login process
        $validated = $request->validate([
            "instructor_id" => ['required', 'min:3','numeric'],
            "password" => ['required', 'min:8'],
        ]);
        // dd($validated);
        if(auth()->guard('instructors')->attempt($validated)){ //login successful
            $request->session()->regenerate(); //create session
            
            $instructor = auth()->guard('instructors')->user();
            $instructor_id = $instructor->instructor_id;

            $evaluation_status = EvaluationStatus::first();
            
            session(['instructor_id' => $instructor->instructor_id, 
                     'firstname' => $instructor->firstname,
                     'pfp' => $instructor->pfp, 
                     'eval_status_p2p' => $evaluation_status->eval_status_p2p]);
            
            //return redirect("/instructor-dashboard")->with('message', 'Welcome Back!');//return redirect to dashboard
            return redirect()->route('instructor.dashboard', ['instructor_id' => $instructor_id])->with('message', 'Welcome back!');
        }else {
          
            return redirect("/")->with('message', 'Invalid Credentials!');//return redirect to dashboard
          
        }   

        return back()->withErrors([ //login failed
            'instructor_id' => 'Invalid Credentials'
        ])->withInput(); //return back to login page
            
    } // end login process

    public function Instructor_dashboard($instructor_id){ //Instructor dashboard
        $AllSubjectCodes = Subject::orderBy('subject_code', 'asc')->get();
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();

        // Get the subjects assigned for instructor
        $assignedSubjects = SubjectAssigned::where('instructor_id', $instructor_id)->get();

        $allSubjectsAssigned = [];

        // Loop through each enrolled subject to get the assigned instructor
        foreach ($assignedSubjects as $subject) {
            $subjectDescription = Subject::where('subject_code', $subject->subject_code)->first();
            
            // Combine the subject and instructor data
            $allSubjectsAssigned[] = [
                'description' => $subjectDescription->description,
                'subject_code' => $subject->subject_code,
                'section' => $subject->section, // Access section property on $subject, not $assignedSubjects
            ];
        }


        return view('instructor-side.instructor-dashboard', compact('instructor', 'allSubjectsAssigned', 'AllSubjectCodes'));
    }

    public function logout(Request $request){//logout
        auth()->guard('instructors')->logout(); 
        $request->session()->invalidate(); //invalidate session
        $request->session()->regenerateToken(); //regenerate token
        return redirect('/')
        ->with('message', 'Logged out')
        ->with('reload', true)
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
    }

    public function AddSubject(Request $request, $instructor_id){ //add subject
        $validated = $request->validate([
            'instructor_id' => ['required'],
            'subject_code' => ['required', 'string'],
            'program' => ['required', 'string'],
            'year' => ['required', 'string'],
            'section' => ['required', 'string'],
        ]);        
        //dd($validated);
        $section = $validated['program'] ." ". $validated['year'] . $validated['section'];

        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();
        $subject = SubjectAssigned::where('subject_code', $validated['subject_code'])
        ->where('instructor_id', $instructor_id)
        ->where('section', $section)
        ->first();

        $section = $validated['program'] ." ". $validated['year'] . $validated['section'];

        $subjectTaken = SubjectAssigned::where('subject_code', $validated['subject_code'])
        ->where('section', $section)
        ->first();
    
        if ($subject) {
             return back()->with('message', 'Subject added already!');
        }

        if ($subjectTaken) {
            return back()->with('message', 'Subject already taken!');
        }

        $section = $validated['program'] ." ". $validated['year'] . $validated['section'];

        $assigned_to =  $validated['subject_code'] . " " . $section;

        $subjectAssigned = SubjectAssigned::create([
            'instructor_id' => $instructor_id,
            'instructor_name' => $instructor->firstname . ' ' . $instructor->lastname,
            'subject_code' => $validated['subject_code'],
            'section' => $section,
            'assigned_to' => $assigned_to,
        ]);


        if ($subjectAssigned) {
            return redirect()->route('instructor.dashboard', ['instructor_id' => $instructor_id])->with('message', 'Subject added successfully!')->with('reload', true);
           
        } else {
            return redirect()->route('instructor.dashboard', ['instructor_id' => $instructor_id])->with('message', 'Failed to add subject!')->with('reload', true);
        }
    }

    public function RemoveSubject($instructor_id, $subject_code){ //remove subject
        $subject = SubjectAssigned::where('instructor_id', $instructor_id)
        ->where('subject_code', $subject_code)
        ->first();
        //dd($subject);
    
        if ($subject) {
            $subject->delete();
            return redirect()->route('instructor.dashboard', ['instructor_id' => $instructor_id])->with('message', 'Subject removed successfully!')->with('reload', true);
        } else {
            return redirect()->route('instructor.dashboard', ['instructor_id' => $instructor_id])->with('message', 'Failed to remove subject!')->with('reload', true);
        }
    }

    //Peer to Peer evaluation
    public function PeertoPeer_Eval($instructor_id) { 
        // Get the peer evaluation record for the given instructor
        $instructor = PeerToPeer::where('instructor_id', $instructor_id)->first();

         // Check if the instructor record exists
            if (!$instructor) {
                // Return an error view or message if the instructor is not found
                return redirect()->back()->with('message', 'Peers have not been assigned yet.');
            }
    
        // Collect the peer IDs
        $peerIds = [
            $instructor->peer1,
            $instructor->peer2,
            $instructor->peer3,
            $instructor->peer4,
            $instructor->peer5
        ];
    
        $AllPeers = [];
    
        // Iterate over the peer IDs and retrieve their details
        foreach ($peerIds as $peerId) {
            $peer = DlcInstructors::where('instructor_id', $peerId)->first();
            if ($peer) {
                $peerEvalStatus = PeerEvaluation::where('instructor_id', $peer->instructor_id)
                ->where('evaluator_id', $instructor_id)
                ->exists();

                $pfps = InstructorAccount::where('instructor_id', $peer->instructor_id)->first();

                $AllPeers[] = [
                    'peerName' => $peer->firstname . ' ' . $peer->lastname,
                    'peerID' => $peer->instructor_id,
                    'status' => $peerEvalStatus ? 'Submitted' : 'Not submitted',
                    'pfp' => $pfps->pfp ?? null,
                ];
            }
        }

       
        return view('instructor-side.instructor-evaluation', compact('instructor', 'AllPeers'));
    }

    //Peer evaluation process
    public function PeerEvaluationProcess(Request $request,) {
        $validated = $request->validate([
            'instructor_id' => ['required', 'string'],
            'evaluator_id' => ['required', 'string'],
            'a_1' => ['required'],
            'a_2' => ['required'],
            'a_3' => ['required'],
            'a_4' => ['required'],
            'a_5' => ['required'],
            'a_6' => ['required'],
            'b_1' => ['required'],
            'b_2' => ['required'],
            'b_3' => ['required'],
            'b_4' => ['required'],
            'b_5' => ['required'],
            'b_6' => ['required'],
            'c_1' => ['required'],
            'c_2' => ['required'],
            'c_3' => ['required'],
            'c_4' => ['required'],
            'c_5' => ['required'],
            'c_6' => ['required'],
            'comments' => ['required'],
        ]);

        $comments = $request->input('comments');
        $analyzer = new Analyzer(); // the analyzer
        // Set the source and target languages
        TranslateTextHelper::setSource('fil')->setTarget('en');

        // Translate the text
        $translatedComment = TranslateTextHelper::translate($comments);

        $sentiment = $analyzer->getSentiment($translatedComment); // get the sentiment of the comments
        $compound = $sentiment['compound']; // Get the compound score from the sentiment

                // Define thresholds for sentiment classification
                $threshold = 0; // Since you're focusing only on positive and negative, use 0 as the threshold

                // Sentiment classification based purely on positive or negative
                if ($compound > $threshold) {
                    $sentimentLabel = 'Best'; // Positive sentiment
                } else {
                    $sentimentLabel = 'Good'; // Negative sentiment
                }
                

        // dd($comments,$translatedComment, $sentiment,$sentimentLabel);
        $validated['sentiment'] = $sentimentLabel;
        $validated['semester'] = request('semester');
        $validated['A_Y'] = request('A_Y');

        $A_total = $validated['a_1'] + $validated['a_2'] + $validated['a_3'] + $validated['a_4'] + $validated['a_5'] + $validated['a_6'];
        $B_total = $validated['b_1'] + $validated['b_2'] + $validated['b_3'] + $validated['b_4'] + $validated['b_5'] + $validated['b_6'];
        $C_total = $validated['c_1'] + $validated['c_2'] + $validated['c_3'] + $validated['c_4'] + $validated['c_5'] + $validated['c_6'];

        $validated['A_Total'] = $A_total;
        $validated['B_Total'] = $B_total;
        $validated['C_Total'] = $C_total;

        $overall_total = $A_total + $B_total + $C_total;

        $validated['overall_total'] = $overall_total;

        //dd($validated);

        $peerEvaluationStatus = PeerEvaluation::where('instructor_id', $validated['instructor_id'])
        ->where('evaluator_id', $validated['evaluator_id'])
        ->where('A_Y', $validated['A_Y'])
        ->exists();

        if ($peerEvaluationStatus) {
            return redirect()->route('instructor.evaluation', ['instructor_id' => $validated['evaluator_id']])->with('message', 'Evaluation Submitted Already!');
        }

        $peerEvaluation = PeerEvaluation::create($validated);
        if ($peerEvaluation) {
            return redirect()->route('instructor.evaluation', ['instructor_id' => $validated['evaluator_id']])->with('message', 'Evaluation Submitted!');
           // return back()->with('message', 'Evaluation submitted successfully');
        } else {
            return redirect()->route('instructor.evaluation', ['instructor_id' => $validated['evaluator_id']])->with('message', 'Evaluation Failed to Submit!');
        }

    
    }
    

    public function updateProfilePage(Request $request, $instructor_id) {
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();
        $peerInstructor = PeerToPeer::where('instructor_id', $instructor_id)->first();
        
        // Initialize $peerIds as an empty array
        $peerIds = [];
    
        if ($peerInstructor) {
            // Collect the peer IDs if $peerInstructor is not null
            $peerIds = [
                $peerInstructor->peer1,
                $peerInstructor->peer2,
                $peerInstructor->peer3,
                $peerInstructor->peer4,
                $peerInstructor->peer5
            ];
        }
    
        if (!function_exists('getCurrentAcademicYear')) {
            function getCurrentAcademicYear() {
                $currentMonth = date('m');
                $currentYear = date('Y');
        
                if ($currentMonth >= 2 && $currentMonth <= 6) {
                    return ($currentYear - 1) . '-' . $currentYear;
                } elseif ($currentMonth >= 8 && $currentMonth <= 12) {
                    return $currentYear . '-' . ($currentYear + 1);
                } else {
                    if ($currentMonth == 1 || $currentMonth == 7) {
                        return ($currentYear - 1) . '-' . $currentYear;
                    }
                }
            }
        }
    
        $AllPeers = [];
        $selectedAcademicYear = $request->input('academic_year');
        if ($selectedAcademicYear == null) {
            $selectedAcademicYear = getCurrentAcademicYear();
        }
    
        // Iterate over the peer IDs and retrieve their details
        foreach ($peerIds as $peerId) {
            $peer = DlcInstructors::where('instructor_id', $peerId)->first();
            if ($peer) {
                $peerEvalStatus = PeerEvaluation::where('instructor_id', $peer->instructor_id)
                    ->where('evaluator_id', $instructor_id)
                    ->exists();
    
                $pfps = InstructorAccount::where('instructor_id', $peer->instructor_id)->first();
    
                $AllPeers[] = [
                    'peerName' => $peer->firstname . ' ' . $peer->lastname,
                    'peerID' => $peer->instructor_id,
                    'status' => $peerEvalStatus ? 'Submitted' : 'Not submitted',
                    'pfp' => $pfps->pfp ?? null,
                ];
            }
        }
    
        // Retrieve previous evaluations based on the selected academic year
        $previousEvaluations = PeerEvaluation::where('evaluator_id', $instructor_id)
            ->where('A_Y', $selectedAcademicYear)
            ->get()
            ->map(function ($evaluation) {
                // $instructor = InstructorAccount::where('instructor_id', $evaluation->instructor_id)->first();

                $instructorBackup = DlcInstructors::where('instructor_id', $evaluation->instructor_id)->first();
        
            
                    $instructorName = $instructorBackup->firstname . ' ' . $instructorBackup->lastname;
                    $department = $instructorBackup->department;
               
        
                return [
                    'instructor_name' => $instructorName,
                    'semester' => $evaluation->semester,
                    'department' => $department,
                ];
            });
    
        return view('instructor-side.instructor-profile', compact('instructor', 'AllPeers', 'previousEvaluations', 'selectedAcademicYear'));
    }
    
    


    public function updateProfileForm($instructor_id){ //update profile form
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();
        return view('instructor-side.update-profile', compact('instructor'));
    }

    public function updateProfile(Request $request, $instructor_id){    //update profile
        $validated = $request->validate([
            'contact' => ['required', 'digits:11'],
            "firstname" => ['required', 'string', 'min:2'],
            "middlename" => ['required', 'string', 'min:2'],
            "lastname" => ['required', 'string', 'min:2'],
            "email" => ['required', 'email'],
            "department" => ['required', 'string'],
            "pfp" => ['image', 'mimes:jpeg,png,jpg', 'nullable'],
        ]);
        // dd($validated);
       
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();

        if (!$instructor) {
            return redirect()->route('instructor.profile', ['instructor_id' => $instructor_id])->with('message', 'Failed!')->with('reload', true);
        }
        
        try {
            $path = null;
        
            if (isset($validated['pfp']) && $validated['pfp'] != null) {
                $fileName = $request->file('pfp');
                $path = $request->file('pfp')->store('public/images/pfp');
                $validated['pfp'] = $fileName->hashName();
            }
        
            $instructor->update($validated);
            session(['student_id' => $instructor->instructor_id, 
                     'pfp' => $instructor->pfp, ]);
            
                     return redirect()->route('instructor.profile', ['instructor_id' => $instructor_id])->with('message', 'Updated Successfully!')->with('reload', true);
        
        } catch (\Exception $e) {
            if ($path !== null) {
                Storage::delete($path);
            }
            return redirect('/instructor-profile')->with('message', 'Profile update failed')->with('reload', true);
        }
        
    }

    public function changePassword(Request $request, $instructor_id) { //change password
        $validated = $request->validate([
            "oldpassword" => ['required'],
            "newpassword" => ['required'],
            "con_pass" => ['required'],
        ]);
        // dd($validated);
        if(strlen($request->input('newpassword')) < 8 ){
            return redirect()->route('instructor.profile', ['instructor_id' => $instructor_id])->with('message', 'Password must be at least 8 characters long');
        }
        

        if($request->input('newpassword') !== $request->input('con_pass')){
            return redirect()->route('instructor.profile', ['instructor_id' => $instructor_id])->with('message', 'Passwords do not match!');
        }
    
        // Find the student by ID
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->firstOrFail();
    
        // Check if the old password matches the one stored in the database
        if (password_verify($request->input('oldpassword'), $instructor->password)) {
            // Hash the new password before updating the database
            $hashedPassword = bcrypt($request->input('newpassword'));
    
            // Update the password
            $instructor->password = $hashedPassword;
            $instructor->save();
    
            // Redirect with success message
            return redirect()->route('instructor.profile', ['instructor_id' => $instructor_id])->with('message', 'Password changed!');
        } else {
            // Redirect with error message
            return redirect()->route('instructor.profile', ['instructor_id' => $instructor_id])->with('message', 'Incorrect Password!');
        }
    }

     // Instructor Feedback Side -----------------------------
     public function SubmitFeedback(Request $request){ // Instructor feedback side
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

    public function viewComments($instructor_id) {
        // Retrieve the search parameters
        $academicYear = request()->input('academic_year');
        $semester = request()->input('semester');

        if (!function_exists('getCurrentSemester')) {
            function getCurrentSemester() {
                $currentMonth = date('m');
        
                if ($currentMonth >= 8 && $currentMonth <= 12) {
                    return '1st';
                } elseif ($currentMonth >= 2 && $currentMonth <= 6) {
                    return '2nd';
                } else {
                    return 'semestral break'; // January is enrollment period, so no current semester
                }
            }
        }
        
        if (!function_exists('getCurrentAcademicYear')) {
            function getCurrentAcademicYear() {
                $currentMonth = date('m');
                $currentYear = date('Y');
        
                if ($currentMonth >= 2 && $currentMonth <= 6) {
                    // If the current month is between February and June, it's the second semester of the academic year
                    return ($currentYear - 1) . '-' . $currentYear;
                } elseif ($currentMonth >= 8 && $currentMonth <= 12) {
                    // If the current month is between August and December, it's the first semester of the academic year
                    return $currentYear . '-' . ($currentYear + 1);
                } else {
                    // For January and July, we assume the academic year spans two years
                    // January is considered part of the second semester's academic year
                    if ($currentMonth == 1 || $currentMonth == 7) {
                        return ($currentYear - 1) . '-' . $currentYear;
                    }
                }
            }
        }
    
        // If no academic year is provided, set to the current academic year
        if (!$academicYear) {
            $academicYear = getCurrentAcademicYear();
        }
    
        // If no semester is provided, set to the current semester
        if (!$semester) {
            $semester = getCurrentSemester();
        }
    
        // Retrieve instructor details
        $instructor = DlcInstructors::where('instructor_id', $instructor_id)->first();

        // Retrieve blocked/filtered words
        $filteredWords = FilterWords::pluck('word')->toArray(); // Get an array of filtered words

        // Query to retrieve comments based on filters
        $commentsQuery = StudentEvaluation::where('instructor_id', $instructor_id);

        // Apply academic year filter
        if ($academicYear) {
            $commentsQuery->where('A_Y', $academicYear);
        }

        // Apply semester filter
        if ($semester) {
            $commentsQuery->where('semester', $semester);
        }

        // Apply filter for blocked words
        if (!empty($filteredWords)) {
            foreach ($filteredWords as $word) {
                $commentsQuery->where('comments', 'NOT LIKE', "%{$word}%");
            }
        }

        // Fetch the comments
        $comments = $commentsQuery->orderBy('created_at', 'desc')->get();

    
        // Return the view with the comments and instructor details
        return view('instructor-side.instructor-comments', compact('comments', 'instructor', 'semester','academicYear'));
    }
    
    
    
    
    

}
