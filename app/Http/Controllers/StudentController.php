<?php

namespace App\Http\Controllers;

use App\Models\StudentAccount;
use Illuminate\Http\Request;
use App\Models\Student;


class StudentController extends Controller
{
    // 
    public function registerStudent(Request $request){

        $validated = $request->validate([
            "student_id" => ['required', 'unique:student_accounts'],
            'contact' => ['required', 'digits:11'],
            "first_name" => ['required', 'string', 'min:2'],
            "middle_name" => ['required', 'string', 'min:2'],
            "last_name" => ['required', 'string', 'min:2'],
            "email" => ['required', 'email', 'unique:student_accounts'],
            "program" => ['required', 'string'],
            "password" => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        // Combine first_name, middle_name, and last_name into a single name field
        $validated['name'] = $request->input('first_name') . ' ' . $request->input('middle_name') . ' ' . $request->input('last_name');
        
        // Remove first_name, middle_name, and last_name from the validated data
        unset($validated['first_name']);
        unset($validated['middle_name']);
        unset($validated['last_name']);
        

        // dd($validated);
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
            session(['student_id' => $student->student_id]);
            
            return redirect("/student-dashboard")->with('message', 'Welcome Back!');//return redirect to dashboard
        }else {
            // Log the input for debugging purposes
            error_log($request->studentID);
          
        }   

        return back()->withErrors([ //login failed
            'studentID' => 'Invalid Credentials'
        ])->withInput(); //return back to login page
    }

    public function Student_dashboard(){ //student dashboard
        return view('student-side.student-dashboard');
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

        
}
