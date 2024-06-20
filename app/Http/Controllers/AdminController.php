<?php

namespace App\Http\Controllers;

use App\Models\AdminAccount;
use App\Models\InstructorAccount;
use App\Models\StudentEvaluation;
use App\Models\SubjectAssigned; // Add this line
use App\Models\StudentsTokenAccounts; // Add this line
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
            
            session(['admin_id' => $admin->admin_id, 
                     'firstname' => $admin->firstname,
                     'lastname' => $admin->lastname,]);
            
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
        return view('admin-side.admin-students', compact('admin'));
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

                
                $randomToken = bin2hex(random_bytes(10));

                // Check if the token is unique
                while (StudentsTokenAccounts::where('eval_token', $randomToken)->exists()) {
                    $randomToken = bin2hex(random_bytes(10));
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
    

}
