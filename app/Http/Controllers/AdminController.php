<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use App\Models\InstructorAccount;
use App\Models\StudentEvaluation;
use App\Models\SubjectAssigned; // Add this line
use App\Models\StudentsTokenAccounts; // Add this line
use App\Models\EvaluationStatus;
use App\Models\PeerToPeer;
use App\Models\DlcInstructors;
use App\Models\PeerEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Mail\EvaluationTokenMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Exception;

class AdminController extends Controller
{
    //Registers the admin account
    public function registerAdmin(Request $request){
        $validated = $request->validate([
            "admin_id" => ['required', 'min:3','numeric'],
            "firstname" => ['required', 'min:3'],
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
          
            return redirect("/")->with('message', 'Invalid Credentials!');//return redirect to dashboard
          
        }   

        return back()->withErrors([ //login failed
            'invalid' => 'Invalid Credentials'
        ])->withInput(); //return back to login page
            
    } // end login process

    public function logout(Request $request){//logout
        auth()->guard('admins')->logout(); 
        $request->session()->invalidate(); //invalidate session
        $request->session()->regenerateToken(); //regenerate token
        return redirect('/admin/login')
        ->with('message', 'Logged out')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
    }


    public function Admin_dashboard($admin_id) {
        $admin = AdminAccount::where('admin_id', $admin_id)->first();
    
        // Get all instructors
        $instructors = InstructorAccount::all();
    
        $allInstructorsData = [];
    
        // Loop through each instructor to gather the required information
        foreach ($instructors as $instructor) {
            // Get the subjects assigned to the instructor
            $assignedSubjects = SubjectAssigned::where('instructor_id', $instructor->instructor_id)->get();
    
            $totalEvaluators = 0;
    
            foreach ($assignedSubjects as $subject) {
                $subjectCode = $subject->subject_code. ' ' . $subject->section;
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
            $completedEvaluations = StudentEvaluation::where('instructor_id', $instructor->instructor_id)->count();
    
            // Combine the instructor data
            $allInstructorsData[] = [
                'name' => $instructor->firstname . ' ' . $instructor->lastname,
                'department' => $instructor->department,
                'total_evaluators' => $totalEvaluators,
                'completed_evaluations' => $completedEvaluations,
            ];
        }
       
    
        return view('admin-side.admin-dashboard', compact('admin', 'allInstructorsData'));
    }





    // Admin student management
    public function Admin_manageStudent($admin_id){
        $admin = AdminAccount::where('admin_id', $admin_id)->first();
        $totalCount = StudentsTokenAccounts::all()->count();
        $completedCount = StudentEvaluation::all()->count();

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
    

    //upload student
    public function uploadStudents(Request $request){
        $request->validate([
            'students_csv' => 'required|file|mimes:csv,txt',
        ]);
        
        $file = $request->file('students_csv');
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
                //dd($rowData);
                // Generate a random token

                
                $randomToken = bin2hex(random_bytes(5));

                // Check if the token is unique
                while (StudentsTokenAccounts::where('eval_token', $randomToken)->exists()) {
                    $randomToken = bin2hex(random_bytes(5));
                }

                // Insert or update student record
                try {
                    // Insert or update student record
                   
                    StudentsTokenAccounts::updateOrCreate(
                        ['student_id' => $rowData['student_id']],
                        [
                            'email' => $rowData['email'], // Generate a random email address if email is empty
                            'eval_token' => $randomToken, // Use the generated random token'test' => $rowData['email'],
                            'subject1' => $rowData['subject1'] ?? 'empty',
                            'subject2' => $rowData['subject2'] ?? null,
                            'subject3' => $rowData['subject3'] ?? null,
                            'subject4' => $rowData['subject4'] ?? null,
                            'subject5' => $rowData['subject5'] ?? null,
                            'subject6' => $rowData['subject6'] ?? null,
                            'subject7' => $rowData['subject7'] ?? null,
                            'subject8' => $rowData['subject8'] ?? null,
                            'subject9' => $rowData['subject9'] ?? null,
                            'subject10' => $rowData['subject10'] ?? null,
                            
                        ]
                     
                    );
                
                } catch (\Exception $e) {
                    dd($e->getMessage()); // Output any exception message
                }
            }
        });


        return redirect()->route('admin.manageStudent', ['admin_id' => session('admin_id')])->with('message', 'Record added successfuly!');
    
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

                        foreach ($students as $student) {
                            $email = $student->email;
                            $token = $student->eval_token;

                            //send token via email
                            // Assuming $students is a collection of student objects
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

        $totalCount = PeerToPeer::count(); // Count of all peer-to-peer evaluations that need to be completed
        $completedCount = PeerEvaluation::count(); // Count of completed peer evaluations

        $students = StudentsTokenAccounts::all();
        $totalEvaluations = $totalCount * 5; // Total evaluations needed if each instructor needs to evaluate 5 instructors

        // Check if $totalEvaluations is zero to avoid division by zero
        if ($totalEvaluations > 0) {
            $completionPercentage = number_format(($completedCount / $totalEvaluations) * 100, 2);
        } else {
            $completionPercentage = 0; // or any default value
        }
        
        return view('admin-side.admin-instructors', compact('admin', 'completionPercentage','completedCount','totalEvaluations'));
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
    public function assignPeerToPeer(Request $request){

        $instructors = DlcInstructors::all();
    
        // Shuffle the instructors to randomize the order
        $shuffledInstructors = $instructors->shuffle();
    
        // Create an array to store the assigned validators
        $assignedValidators = [];
    
        foreach ($instructors as $instructor) {
            $validatorIds = $shuffledInstructors->pluck('instructor_id')->diff([$instructor->instructor_id])->take(5)->toArray();
            $assignedValidators[$instructor->instructor_id] = $validatorIds;
        }
        
    
        // Insert the assigned validators into the database
        foreach ($assignedValidators as $instructorId => $validatorIds) {
            $validatorIds = array_values($validatorIds);
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
    
        return redirect()->route('admin.manageInstructor', ['admin_id' => session('admin_id')])->with('message', 'Peer assigned successfully!');
    }
    
    

    

}
