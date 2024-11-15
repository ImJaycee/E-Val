<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use App\Models\InstructorAccount;
use App\Models\StudentEvaluation;
use App\Models\SubjectAssigned; 
use App\Models\StudentsTokenAccounts; 
use App\Models\StudentArchives; 
use App\Models\InstructorArchives; 
use App\Models\EvaluationStatus;
use App\Models\PeerToPeer;
use App\Models\DlcInstructors;
use App\Models\PeerEvaluation;
use App\Models\UsersFeedback;
use App\Models\FilterWords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use App\Mail\EvaluationTokenMail;
use App\Models\Subject;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    //Registers the admin account
    public function registerAdmin(Request $request){
        $validated = $request->validate([
            "admin_id" => ['required', 'min:3','numeric'],
            "firstname" => ['required', 'min:3'],
            "middlename" => ['required', 'min:3'],
            "lastname" => ['required', 'min:3'],
            "email" => ['required', 'email'],
            "password" => ['required', 'min:8'],
            "confirm_password" => ['required', 'same:password'],
        ]);     
       
        $existingAccount = AdminAccount::where('admin_id', $validated['admin_id'])
        ->orWhere('email', $validated['email'])->first();
        $validated['password'] = bcrypt($validated['password']); //validate password and bcrypt password
        if($existingAccount){
            return redirect("/admin/login")->with('message', 'Account already exists!');//return redirect to register page
        }
        
            if ($admin = AdminAccount::create($validated)) {
                return redirect('/admin/login')->with('message', 'Account created successfully');
            } else {
                return redirect('/admin/login')->with('error', 'Failed to create account');
            }
        
    }

    //Login admin
    public function Admin_loginprocess(Request $request){ // login process
        $validated = $request->validate([
            "admin_id" => ['required', 'min:3','numeric'],
            "password" => ['required', 'min:8'],
        ]);
        
        if(auth()->guard('admins')->attempt($validated)){ //login successful
            $request->session()->regenerate(); //create session
            $admin = auth()->guard('admins')->user();
            $admin_id = $admin->admin_id;

            $evaluation_status = EvaluationStatus::first();

            
            session(['admin_id' => $admin->admin_id, 
                     'firstname' => $admin->firstname,
                     'lastname' => $admin->lastname,
                     'eval_status' => $evaluation_status->eval_status,
                     'eval_status_p2p' => $evaluation_status->eval_status_p2p]);
            
            //return redirect("/instructor-dashboard")->with('message', 'Welcome Back!');//return redirect to dashboard

            return redirect()->route('admin.dashboard', ['admin_id' => $admin_id])->with('message', 'Welcome back!');
        }else {
          
            return back()->with('message', 'Invalid Credentials!');//return redirect to dashboard
          
        }   

        return back()->withErrors([ //login failed
            'invalid' => 'Invalid Credentials'
        ])->withInput(); //return back to login page
            
    } // end login process

    public function logout(Request $request)
    {
            auth()->guard('admins')->logout(); 
            $request->session()->invalidate(); 
            $request->session()->regenerateToken(); 
            
            return redirect('/admin/login')
                ->with('message', 'Logged out')
                ->with('reload', true)
                ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
                ->header('Pragma', 'no-cache');
    }


    public function Admin_dashboard($admin_id) {
        // Fetch admin details
        $admin = AdminAccount::where('admin_id', $admin_id)->first();

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

        // Get all instructors
        $instructors = InstructorAccount::all();

        $allInstructorsData = [];

        // Loop through each instructor to gather the required information
        foreach ($instructors as $instructor) {
            // Get the subjects assigned to the instructor
            $assignedSubjects = SubjectAssigned::where('instructor_id', $instructor->instructor_id)->get();

            $totalEvaluators = 0;

            foreach ($assignedSubjects as $subject) {
                $subjectCode = $subject->subject_code . ' ' . $subject->section;
                $studentsEnrolled = StudentsTokenAccounts::where('subject1', $subjectCode)
                                                        ->orWhere('subject2', $subjectCode)
                                                        ->orWhere('subject3', $subjectCode)
                                                        ->orWhere('subject4', $subjectCode)
                                                        ->orWhere('subject5', $subjectCode)
                                                        ->orWhere('subject6', $subjectCode)
                                                        ->orWhere('subject7', $subjectCode)
                                                        ->orWhere('subject8', $subjectCode)
                                                        ->orWhere('subject9', $subjectCode)
                                                        ->orWhere('subject10', $subjectCode)
                                                        ->count();

                $totalEvaluators += $studentsEnrolled;
            }

            // Get the completed evaluations count for the instructor
            $semester = getCurrentSemester();
            $academicYear = getCurrentAcademicYear();
            
            $completedEvaluations = StudentEvaluation::where('instructor_id', $instructor->instructor_id)
            ->where('semester',$semester)
            ->where('A_Y',$academicYear)
            ->count();

            // Calculate percentages
            $totalEvaluatorsPercent = ($totalEvaluators > 0) ? ($completedEvaluations / $totalEvaluators) * 100 : 0;

            // Combine the instructor data
            $allInstructorsData[] = [
                'name' => $instructor->firstname . ' ' . $instructor->lastname,
                'department' => $instructor->department,
                'total_evaluators' => $totalEvaluators,
                'total_evaluators_percent' => round($totalEvaluatorsPercent, 2), // Round to two decimal places
                'completed_evaluations' => $completedEvaluations,
            ];
        }

        return view('admin-side.admin-dashboard', compact('admin', 'allInstructorsData'));
    }

    // Admin student management
    public function Admin_manageStudent($admin_id){
        $admin = AdminAccount::where('admin_id', $admin_id)->first();

        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 2 && $currentMonth <= 6) {
            // If the current month is between February and June, it's the second semester of the academic year
            $A_Y = ($currentYear - 1) . '-' . $currentYear;
            $semester = '2nd';
        } elseif ($currentMonth >= 8 && $currentMonth <= 12) {
            // If the current month is between August and December, it's the first semester of the academic year
            $A_Y = $currentYear . '-' . ($currentYear + 1);
            $semester = '1st';
        } else {
            // For January and July, we assume the academic year spans two years
            // January is considered part of the second semester's academic year
            if ($currentMonth == 1 || $currentMonth == 7) {
                $A_Y = ($currentYear - 1) . '-' . $currentYear;
                $semester = '2nd';
            }
        }

        $totalCount = StudentsTokenAccounts::all()->count();
        $completedCount = StudentEvaluation::where('semester',$semester)->where('A_Y',$A_Y)->count(); 

        $students = StudentsTokenAccounts::all();

        $StudenttotalEvaluations = 0;
        foreach ($students as $student){
            for($i = 1; $i <= 10; $i++){
                $subject = 'subject'.$i;
                if($student->$subject != null){
                    $StudenttotalEvaluations++;
                }
            }
        }
        
        // Check if $totalCount is zero to avoid division by zero
        if ($totalCount > 0) {
            $completionPercentage = number_format(($completedCount / $StudenttotalEvaluations) * 100, 2);
        } else {
            $completionPercentage = 0; // or any default value
        }
        
        return view('admin-side.admin-students', compact('admin', 'completionPercentage','completedCount','StudenttotalEvaluations'));
    }
    

     //upload instructor
     public function uploadInstructors(Request $request){
        $request->validate([
            'instructors_csv' => 'required|file|mimes:csv',
        ]);
        
        $file = $request->file('instructors_csv');
        $filePath = $file->getRealPath();
        
        $csvData = array_map('str_getcsv', file($filePath));
        
        // Set row 9 as the header (array index 8 since indexing starts at 0)
        $headerRowIndex = 8; // This corresponds to the 9th row
        
        // Get the header from the specified row
        $header = $csvData[$headerRowIndex];
        
        // Skip rows up to the specified header row
        $csvData = array_slice($csvData, $headerRowIndex + 1);

        
       // Insert or update student records within a transaction
        DB::transaction(function () use ($csvData, $header) {
            foreach ($csvData as $row) {
                $rowData = array_combine($header, $row);

                // Insert or update student record
                try {
                    // Insert or update student record
                    if(session('eval_status_p2p') == 'open'){
                        return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])->with('message', 'Cannot clear peer assignment while evaluation is ongoing!');
                    }
                   
                    DlcInstructors::updateOrCreate(
                        ['instructor_id' => $rowData['instructor_id']],
                        [
                            'firstname' => $rowData['firstname'], // 
                            'middlename' => $rowData['middlename'], // 
                            'lastname' => $rowData['lastname'], // 
                            'sex' => $rowData['sex'], // 
                            'department' => $rowData['department'],
                            
                        ]
                     
                    );
                
                } catch (\Exception $e) {
                    dd($e->getMessage()); // Output any exception message
                }
            }
        });


        return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])->with('message', 'Record added successfuly!');
    
    }

    // Evaluation control
    public function Admin_EvalControl(Request $request){
        $validated = $request->validate([
            'eval_status' => ['required'],
        ]);

        $status = $validated['eval_status'];
        $evalStatus = EvaluationStatus::first();
        $evalStatus->eval_status = $status;
        $evalStatus->save();

                if ($status == 'open') {

                        $students = StudentsTokenAccounts::all();

                            //send token via email
                            foreach ($students as $student) {
                                $email = $student->email;
                                $token = $student->eval_token;
                            
                                $attempts = 0;
                                $maxAttempts = 3;
                                $sent = false;
                            
                                while (!$sent && $attempts < $maxAttempts) {
                                    try {
                                        // Send token via email
                                        Mail::to($email)->send(new EvaluationTokenMail($token));
                                        echo "Email sent to: $email\n";
                                        $sent = true;
                                    } catch (Exception $e) {
                                        $attempts++;
                                        Log::error("Failed to send email to $email (Attempt $attempts): " . $e->getMessage());
                            
                                        if ($attempts >= $maxAttempts) {
                                            // Notify admin or take necessary actions
                                            echo "Failed to send email to: $email after $attempts attempts. Error: " . $e->getMessage() . "\n";
                                        } else {
                                            // Wait before retrying (e.g., wait for 5 seconds)
                                            sleep(5);
                                        }
                                    }
                                }
                            }
                            
                }

        session(['eval_status' => $status]);

        if ($status == 'open') {
            return redirect()->route('admin.manageStudent', ['admin_id' => session('admin_id')])->with('message', 'Evaluation Started!');
        }else{
            return redirect()->route('admin.manageStudent', ['admin_id' => session('admin_id')])->with('message', 'Evaluation Closed!');
        }
        
        
    }


    // manage instructor peer to peer 
    public function Admin_manageInstructor($admin_id){
        $admin = AdminAccount::where('admin_id', $admin_id)->first();

        $currentMonth = date('m');
        $currentYear = date('Y');

        if ($currentMonth >= 2 && $currentMonth <= 6) {
            // If the current month is between February and June, it's the second semester of the academic year
            $A_Y = ($currentYear - 1) . '-' . $currentYear;
            $semester = '2nd';
        } elseif ($currentMonth >= 8 && $currentMonth <= 12) {
            // If the current month is between August and December, it's the first semester of the academic year
            $A_Y = $currentYear . '-' . ($currentYear + 1);
            $semester = '1st';
        } else {
            // For January and July, we assume the academic year spans two years
            // January is considered part of the second semester's academic year
            if ($currentMonth == 1 || $currentMonth == 7) {
                $A_Y = ($currentYear - 1) . '-' . $currentYear;
                $semester = '2nd';
            }
        }


        $totalCount = PeerToPeer::count(); // Count of all peer-to-peer evaluations that need to be completed
        $completedCount = PeerEvaluation::where('semester', $semester)->where('A_Y',$A_Y)->count(); // Count of completed peer evaluations

        $totalEvaluations = $totalCount * 5; // Total evaluations needed if each instructor needs to evaluate 5 instructors

        // Check if $totalEvaluations is zero to avoid division by zero
        if ($totalEvaluations > 0) {
            $completionPercentage = number_format(($completedCount / $totalEvaluations) * 100, 2);
        } else {
            $completionPercentage = 0; // or any default value
        }
        
        return view('admin-side.admin-instructors', compact('admin', 'completionPercentage','completedCount','totalEvaluations'));
    }

    //Clear peer to peer
    public function clearPeerToPeer(Request $request){ // clear peer to peer
        if(session('eval_status_p2p') == 'open'){
            return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])->with('message', 'Cannot clear peer assignment while evaluation is ongoing!');
        }
        PeerToPeer::truncate();
        return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])->with('message', 'Peer Assignment cleared!');
    }

    // Evaluation control Peer to peer
    public function Admin_EvalControlPtP(Request $request){
        $validated = $request->validate([
            'eval_status_p2p' => ['required'],
        ]);

        $status = $validated['eval_status_p2p'];
        $evalStatus = EvaluationStatus::first();
        $evalStatus->eval_status_p2p = $status;
        $evalStatus->save();

                if ($status == 'open') {

                }

        session(['eval_status_p2p' => $status]);

        if ($status == 'open') {
            return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])->with('message', 'Evaluation Started!');
        }else{
            return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])->with('message', 'Evaluation Closed!');
        }
        
        
    }

    //assign peer to peer
    public function assignPeerToPeer(Request $request) { 
        // Fetch all instructors
        $instructors = DlcInstructors::all();
    
        // Check if there are at least 6 instructors
        if ($instructors->count() < 6) {
            return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])
                             ->with('message', 'There must be at least six instructors to assign peers!');
        }
    
        // Shuffle the instructors to randomize the order
        $shuffledInstructors = $instructors->shuffle()->values(); // Ensure shuffled list uses numeric keys
    
        // Create an array to store the assigned validators
        $assignedValidators = [];
    
        $totalInstructors = $shuffledInstructors->count();
    
        foreach ($shuffledInstructors as $index => $instructor) {
            $validatorIds = [];
    
            // Assign the next 5 instructors in a circular fashion
            for ($i = 1; $i <= 5; $i++) {
                $nextIndex = ($index + $i) % $totalInstructors; // Wrap around the list using modulo
                $validatorIds[] = $shuffledInstructors[$nextIndex]->instructor_id;
            }
    
            // Assign the validators to the current instructor
            $assignedValidators[$instructor->instructor_id] = $validatorIds;
        }
    
        // Insert the assigned validators into the database
        foreach ($assignedValidators as $instructorId => $validatorIds) {
            PeerToPeer::updateOrCreate(
                ['instructor_id' => $instructorId],
                [
                    'peer1' => $validatorIds[0],
                    'peer2' => $validatorIds[1],
                    'peer3' => $validatorIds[2],
                    'peer4' => $validatorIds[3],
                    'peer5' => $validatorIds[4],
                    'status' => 'assigned' // Assuming this is the default status
                ]
            );
        }
    
        // Redirect back with success message
        return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])
                         ->with('message', 'Peers assigned successfully!');
    }
    
    
    



    // Admin Comments view controller
    public function viewComments($admin_id){ // view Student comments
        $admin = AdminAccount::where('admin_id', $admin_id)->first();
        $instructors = InstructorAccount::all();
        return view('admin-side.admin-comments', compact('admin', 'instructors'));
    }

    public function showComments(Request $request, $admin_id, $instructor_id){ // show comments
        
        $academicYear = request()->input('academic_year');
        $semester = request()->input('semester');
        $sentiment = request()->input('sentiment');

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
    
        // Query to retrieve comments based on filters
        $commentsQuery = StudentEvaluation::where('instructor_id', $instructor_id);

        if ($sentiment){
            $commentsQuery = StudentEvaluation::where('instructor_id', $instructor_id)
            ->where('sentiment', $sentiment);
        }
    
        if ($academicYear) {
            $commentsQuery->where('A_Y', $academicYear);
        }
    
        if ($semester) {
            $commentsQuery->where('semester', $semester);
        }

    
        $comments = $commentsQuery->orderBy('created_at', 'desc')->get();
        
        return view('admin-side.admin-show-comments', compact('comments', 'instructor', 'semester','academicYear'));
    }

    public function showPeerComments(Request $request, $admin_id, $instructor_id){ // show comments
        
        $academicYear = request()->input('academic_year');
        $semester = request()->input('semester');
        $sentiment = request()->input('sentiment');

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
    
        // Query to retrieve comments based on filters
        $commentsQuery = PeerEvaluation::where('instructor_id', $instructor_id);

        if ($sentiment){
            $commentsQuery = PeerEvaluation::where('instructor_id', $instructor_id)
            ->where('sentiment', $sentiment);
        }
    
        if ($academicYear) {
            $commentsQuery->where('A_Y', $academicYear);
        }
    
        if ($semester) {
            $commentsQuery->where('semester', $semester);
        }
    
        $comments = $commentsQuery->orderBy('created_at', 'desc')->get();
        
        return view('admin-side.admin-peer-comments', compact('comments', 'instructor', 'semester','academicYear'));
    }


    public function viewFeedback($admin_id){ // admin view feedback
        $feedbacks = UsersFeedback::all();

        // Calculate the average rating
        $averageRating = $feedbacks->avg('rating');
        
        return view('admin-side.users-feedbacks', compact('feedbacks', 'averageRating'));
        
    }

    public function viewReport($admin_id){ // generate a report
        return view('admin-side.admin-reports');
        
    }

    public function viewSummary(Request $request){  // view summary
        $academicYear = $request->input('A_Y');
        $semester = $request->input('semester');
    
        // Fetch summarized data based on academic year and semester
        $instructors = InstructorAccount::with(['evaluations' => function ($query) use ($academicYear, $semester) {
            $query->where('A_Y', $academicYear)
                ->where('semester', $semester)
                ->selectRaw('instructor_id, AVG(total_score) as average_rating')
                ->groupBy('instructor_id');
        }])
        ->get();
    
        // Ensure average rating is accessible and formatted
        $instructors->each(function ($instructor) {
            if ($instructor->evaluations->isNotEmpty()) {
                // Get the average rating and convert it to a percentage
                $averageRating = $instructor->evaluations->first()->average_rating;
                $instructor->rating = number_format(($averageRating / 70) * 100, 1);
            } else {
                // Default to null if no evaluations
                $instructor->rating = null;
            }
        });
    
        // Sort instructors by rating (descending) and then by lastname (ascending)
        $instructors = $instructors->sortByDesc('rating')->sortBy('lastname');
    
        return view('admin-side.report-summary', compact('instructors', 'academicYear', 'semester'));
    }
    
    public function viewSummary_Ranking(Request $request){ // view summary ranking
        $academicYear = $request->input('A_Y');
        $semester = $request->input('semester');
    
        // Fetch summarized data based on academic year and semester
        $instructors = InstructorAccount::with(['evaluations' => function ($query) use ($academicYear, $semester) {
            $query->where('A_Y', $academicYear)
                ->where('semester', $semester)
                ->selectRaw('instructor_id, AVG(total_score) as average_rating')
                ->groupBy('instructor_id');
        }])
        ->get();
    
        // Ensure average rating is accessible and formatted
        $instructors->each(function ($instructor) {
            if ($instructor->evaluations->isNotEmpty()) {
                // Get the average rating and convert it to a percentage
                $averageRating = $instructor->evaluations->first()->average_rating;
                $instructor->rating = number_format(($averageRating / 70) * 100, 1);
            } else {
                // Default to null if no evaluations
                $instructor->rating = null;
            }
        });
    
        // Sort instructors by rating (descending) and then by lastname (ascending)
        $instructors = $instructors->sortByDesc('rating');
    
        return view('admin-side.report-summary', compact('instructors', 'academicYear', 'semester'));
    }

    public function viewSummary_PeertoPeer(Request $request){ // view summary student evaluation summary
        $academicYear = $request->input('A_Y');
        $semester = $request->input('semester');
    
        // Fetch summarized peer evaluation data based on academic year and semester
        $instructors = InstructorAccount::with(['peerEvaluations' => function ($query) use ($academicYear, $semester) {
            $query->where('A_Y', $academicYear)
                  ->where('semester', $semester)
                  ->selectRaw('instructor_id, AVG(overall_total) as average_rating')
                  ->groupBy('instructor_id');
        }])
        ->get();
    
        // Ensure average rating is accessible and formatted
        $instructors->each(function ($instructor) {
            if ($instructor->peerEvaluations->isNotEmpty()) {
                // Calculate the total score from all peer evaluations
                $totalScore = $instructor->peerEvaluations->sum('average_rating');
                // Count the number of peer evaluations
                $evaluationCount = $instructor->peerEvaluations->count();
                // Calculate the average score and convert it to a percentage (assuming max score of 90)
                $averageRating = $totalScore / $evaluationCount;
                $instructor->rating = number_format(($averageRating / 90) * 100, 1);
            } else {
                // Default to null if no peer evaluations
                $instructor->rating = null;
            }
        });
        
    
        // Sort instructors by rating (descending) and then by lastname (ascending)
        $instructors = $instructors->sortByDesc('rating')->sortBy('lastname');

    
        return view('admin-side.report-summary-peer', compact('instructors', 'academicYear', 'semester'));
    }

    public function viewSummary_PeertoPeer_Rank(Request $request){ //view summary peer to peer ranking
        $academicYear = $request->input('A_Y');
        $semester = $request->input('semester');
    
        // Fetch summarized peer evaluation data based on academic year and semester
        $instructors = InstructorAccount::with(['peerEvaluations' => function ($query) use ($academicYear, $semester) {
            $query->where('A_Y', $academicYear)
                  ->where('semester', $semester)
                  ->selectRaw('instructor_id, AVG(overall_total) as average_rating')
                  ->groupBy('instructor_id');
        }])
        ->get();
    
        // Ensure average rating is accessible and formatted
        $instructors->each(function ($instructor) {
            if ($instructor->peerEvaluations->isNotEmpty()) {
                // Calculate the total score from all peer evaluations
                $totalScore = $instructor->peerEvaluations->sum('average_rating');
                // Count the number of peer evaluations
                $evaluationCount = $instructor->peerEvaluations->count();
                // Calculate the average score and convert it to a percentage (assuming max score of 90)
                $averageRating = $totalScore / $evaluationCount;
                $instructor->rating = number_format(($averageRating / 90) * 100, 1);
            } else {
                // Default to null if no peer evaluations
                $instructor->rating = null;
            }
        });
        
    
        // Sort instructors by rating (descending) and then by lastname (ascending)
        $instructors = $instructors->sortByDesc('rating');

    
        return view('admin-side.report-summary-peer', compact('instructors', 'academicYear', 'semester'));
    }
    
    

    // Admin account management
    public function updateProfilePage(Request $request, $admin_id){
        $admin = AdminAccount::where('admin_id', $admin_id)->first();
        $instructors = DlcInstructors::all()->sortBy('lastname');

        $student_id = $request->input('student_id');
        $department = $request->input('department');

        if ($student_id) {
            $students = StudentsTokenAccounts::where('student_id', $student_id)->get();

            if ($students->isEmpty()) {
                // Set a flash message and retrieve all student records
                $students = StudentsTokenAccounts::all();
                return redirect()->route('admin.profile', ['admin_id' => $admin_id])
                ->with('message', "No student found with the ID {$student_id}.");
            }
        } else {
            $students = StudentsTokenAccounts::all();
        }

        if ($department) {
            $instructors = DlcInstructors::where('department', $department)->get();

            if ($instructors->isEmpty()) {
                // Set a flash message and retrieve all student records
                $students = DlcInstructors::all();
                return redirect()->route('admin.profile', ['admin_id' => $admin_id])
                ->with('message', "No instructor found in the {$department} department.");
            }
        } else {
            $instructors = DlcInstructors::all();
        }

        return view('admin-side.admin-profile-records', compact('admin', 'instructors', 'students'));
    }




    public function updateProfile(Request $request, $admin_id){ // update admin profile
       
        $validated = $request->validate([
            "admin_id" => ['required', 'min:3','numeric'],
            "firstname" => ['required', 'min:2'],
            "middlename" => ['required', 'min:2'],
            "lastname" => ['required', 'min:2'],
            "email" => ['required', 'email'],
        ]);     

    
        $admin = AdminAccount::where('admin_id', $admin_id)->first();

        if(!$admin){
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('error', 'Account not found');
        }
        
        
            if ($admin->update($validated)) {
                session(['firstname' => $admin->firstname, 
                         'lastname' => $admin->lastname,
                        ]);
                return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Account updated successfully');
            } else {
                return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('error', 'Failed to update account');
            }
        
    }

    public function changePassword(Request $request ,$admin_id){ //change password
        $validated = $request->validate([
            "oldpassword" => ['required'],
            "newpassword" => ['required'],
            "con_pass" => ['required'],
        ]);

        if(strlen($request->input('newpassword')) < 8 ){
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Password must be at least 8 characters long');
        }

        if($request->input('newpassword') != $request->input('con_pass')){
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Password does not match');
        }

        $admin = AdminAccount::where('admin_id', $admin_id)->first();

        if (password_verify($request->input('oldpassword'), $admin->password)) {
            // Hash the new password before updating the database
            $hashedPassword = bcrypt($request->input('newpassword'));
    
            // Update the password
            $admin->password = $hashedPassword;
            $admin->save();
    
            // Redirect with success message
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Password changed!');
        } else {
            // Redirect with error message
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Incorrect Password!');
        }
        
    }


    public function removeInstructor(Request $request,$instructor_id){ // remove single instructor
        $validated = $request->validate([
            "RemoveAccount" => ['required',],
        ]);

        $instructor = DlcInstructors::where('instructor_id', $instructor_id)->first();
        $instructor_account = InstructorAccount::where('instructor_id', $instructor_id)->first();

        if(!$instructor){
            return redirect()->route('admin.profile', ['admin_id' => session('admin_id')])->with('message', 'Instructor not found');
        }
        

        if($validated['RemoveAccount'] == 'remove_account' && $instructor_account){

            $archive = InstructorArchives::create([
                'instructor_id' => $instructor_account->instructor_id,
                'firstname' => $instructor_account->firstname,
                'middlename' => $instructor_account->middlename,
                'lastname' => $instructor_account->lastname,
                'email' => $instructor_account->email,
                'sex' => $instructor_account->sex,
                'department' => $instructor_account->department,
                'pfp' => $instructor_account->pfp,
            ]);

            $instructor->delete();
            $instructor_account->delete();
            return redirect()->route('admin.profile', ['admin_id' => session('admin_id')])->with('message', 'Instructor removed successfully');
        }

        if ($instructor){
            $archive = InstructorArchives::create([
                'instructor_id' => $instructor_id,
                'firstname' => $instructor->firstname,
                'middlename' => $instructor->middlename,
                'lastname' => $instructor->lastname,
                'email' => null,
                'sex' => $instructor->sex,
                'department' => $instructor->department,
                'pfp' => null,
            ]);

            $instructor->delete();
            return redirect()->route('admin.profile', ['admin_id' => session('admin_id')])->with('message', 'Instructor removed successfully');
        }

        return redirect()->route('admin.profile', ['admin_id' => session('admin_id')])->with('message', 'Instructor not found');


    }

    public function AddInstructor(Request $request,$admin_id){ // add single instructor 
        $validated = $request->validate([
            "instructor_id" => ['required', 'numeric','min:3'],
            "firstname" => ['required', 'min:2'],
            "middlename" => ['required', 'min:2'],
            "lastname" => ['required', 'min:2'],
            "sex" => ['required'],
            "department" => ['required', 'min:4'],
        ]);

        

        $instructor = DlcInstructors::where('instructor_id', $validated['instructor_id'])->first();

        if($instructor){
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Instructor already exists');
        }

        if ($instructor = DlcInstructors::create($validated)) {
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Instructor added successfully');
        } else {
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('error', 'Failed to add instructor');
        }

    }


    public function updateStudentSubjects(Request $request,$admin_id){//Update student subjects enrolled
        $validated = $request->validate([
            "student_id" => [ 'numeric','min:6'],
        ]);

        $student = StudentsTokenAccounts::where('student_id', $validated['student_id'])->first();

        if(!$student){
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Student not found');
        }

        $student->subject1 = $request->input('subject1');
        $student->subject2 = $request->input('subject2');
        $student->subject3 = $request->input('subject3');
        $student->subject4 = $request->input('subject4');
        $student->subject5 = $request->input('subject5');
        $student->subject6 = $request->input('subject6');
        $student->subject7 = $request->input('subject7');
        $student->subject8 = $request->input('subject8');
        $student->subject9 = $request->input('subject9');
        $student->subject10 = $request->input('subject10');

        
        if ($student->save()){
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('message', 'Subjects updated successfully');
        } else {
            return redirect()->route('admin.profile', ['admin_id' => $admin_id])->with('error', 'Failed to update subjects');
        }
    
    }

    public function moveStudentToArchives(Request $request){ // remove single student
       // Retrieve all students
        $students = StudentsTokenAccounts::all();

        foreach ($students as $student) {
            // Determine academic year and semester based on the `created_at` timestamp
            $timestamp = Carbon::parse($student->created_at);
            $year = $timestamp->year;
            $month = $timestamp->month;

            // Assuming academic year starts in August and semester is split accordingly
            if ($month >= 8) {
                $academicYear = $year . '-' . ($year + 1);
                $semester = '1st Semester';
            } elseif ($month >= 1 && $month < 6) {
                $academicYear = ($year - 1) . '-' . $year;
                $semester = '2nd Semester';
            } else {
                $academicYear = ($year - 1) . '-' . $year;
                $semester = 'Semestral Break';
            }

            //dd($academicYear, $semester);

            // Create a new archive record for each student
            StudentArchives::create([
                'student_id' => $student->student_id,
                'email' => $student->email,
                'eval_token' => $student->eval_token,
                'subject1' => $student->subject1,
                'subject2' => $student->subject2,
                'subject3' => $student->subject3,
                'subject4' => $student->subject4,
                'subject5' => $student->subject5,
                'subject6' => $student->subject6,
                'subject7' => $student->subject7,
                'subject8' => $student->subject8,
                'subject9' => $student->subject9,
                'subject10' => $student->subject10,
                'A_Y' => $academicYear,
                'semester' => $semester,
            ]);
        }

        // Delete all students from the original table after archiving them
        StudentsTokenAccounts::truncate();
            return redirect()->route('admin.profile', ['admin_id' => session('admin_id')])->with('message', 'Students removed successfully');
    }


    public function filterWords(Request $request){
        $validated = $request->validate([
            "word" => ['required', ],
        ]);
        $filter = FilterWords::create($validated);

        if ($filter){
           return redirect()->route('admin.comments', ['admin_id' =>session('admin_id')])->with('message','Word Added to filter successfully');
        }
        return redirect()->route('admin.comments', ['admin_id' =>session('admin_id')])->with('message','try again!');
    }



    //upload student trial
    public function uploadStudentRecord(Request $request){
        $request->validate([
            'students_csv' => 'required|file|mimes:csv',
        ]);
        
        $file = $request->file('students_csv');
        $filePath = $file->getRealPath();
        
        $csvData = array_map('str_getcsv', file($filePath));
        
        // Set row 9 as the header (array index 8 since indexing starts at 0)
        $headerRowIndex = 7; // This corresponds to the 8th row HEADERS


        //get subject code
        $subjectCode = isset($csvData[$headerRowIndex][5]) ? $csvData[$headerRowIndex][5] : null;
        //get section 
        $section =isset($csvData[$headerRowIndex][6]) ? $csvData[$headerRowIndex][6] : null;
        //get instructor id 
        $instructor_id =isset($csvData[$headerRowIndex][7]) ? $csvData[$headerRowIndex][7] : null;

        $assigned_to = $subjectCode." ".$section;

        if ($subjectCode == null || $section == null || $instructor_id == null){
            return redirect()->route('admin.manageStudent', ['admin_id' => session('admin_id')])->with('message', 'Incomplete Data!');
        }

        
        // Fetch subject assignments matching the subject code
        $subjectAssignments = SubjectAssigned::where('assigned_to', $assigned_to)->first(); // Use first() for a single record

        // Check if a record was found before accessing the instructor_name property
        if (!$subjectAssignments) {
            $instructor = DlcInstructors::where('instructor_id', $instructor_id)->first();

            $instructor_name = $instructor->firstname. " " . $instructor->lastname;

            $assign = SubjectAssigned::create([
                'instructor_id' => $instructor_id,
                'instructor_name' => $instructor_name,
                'subject_code' => $subjectCode,
                'section' => $section,
                'assigned_to' => $assigned_to,
            ]);

            if (!$assign){
                return redirect()->route('admin.manageStudent', ['admin_id' => session('admin_id')])->with('message', 'Incomplete Data!');
            }
           
        } 

        //upload student and set subjects  

        // Get the header from the specified row
        $headerRowIndex = 0; 
        $header = $csvData[$headerRowIndex];

        // Slice CSV data to start from row 9 (array index 8)
        $csvData = array_slice($csvData, 8);

        DB::transaction(function () use ($csvData, $header, $assigned_to) {
            foreach ($csvData as $row) {
                $rowData = array_combine($header, $row);
                
                // Generate a random token
                $randomToken = bin2hex(random_bytes(5));
        
                // Check if the token is unique
                while (StudentsTokenAccounts::where('eval_token', $randomToken)->exists()) {
                    $randomToken = bin2hex(random_bytes(5));
                }

                // // prevent adding null rows after the last student
                // if($rowData['StudentNo'] == null){
                //     break;
                // }
        
                // Retrieve student record if exists
                $studentAccount = StudentsTokenAccounts::where('student_id', $rowData['StudentNo'])->first();
                
                // If student doesn't have an existing record, initialize new data with token and email
                $studentData = [
                    'student_id' => $rowData['StudentNo'],
                    'email' => $rowData['StudentNo']."@dhvsu.edu.ph",
                    'eval_token' => $randomToken,
                ];
        
                // If record exists, check if the assigned subject is already added
                if ($studentAccount) {
                    $subjectExists = false;
                    for ($i = 1; $i <= 10; $i++) {
                        $subjectField = "subject$i";
                        if ($studentAccount->$subjectField === $assigned_to) {
                            $subjectExists = true;
                            break;
                        }
                    }
        
                    // If the subject already exists, skip to the next row
                    if ($subjectExists) {
                        continue;
                    }
        
                    // If the subject doesn't exist, find the first available subject field
                    for ($i = 1; $i <= 10; $i++) {
                        $subjectField = "subject$i";
                        if (is_null($studentAccount->$subjectField)) {
                            $studentData[$subjectField] = $assigned_to;
                            break;
                        }
                    }
        
                    // Update existing student record with the new data
                    $studentAccount->update($studentData);
                } else {
                    // If the student record doesn't exist, add the subject to the first subject field
                    $studentData['subject1'] = $assigned_to;
        
                    // Create a new student record
                    StudentsTokenAccounts::create($studentData);
                }
            }
        });


        return redirect()->route('admin.manageStudent', ['admin_id' => session('admin_id')])->with('message', 'Record added successfuly!');
    
    }

    
}
