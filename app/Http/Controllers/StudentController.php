<?php

namespace App\Http\Controllers;

use App\Models\StudentAccount;
use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;


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
            // session(['student_id' => $student->student_id, 'pfp' => $student->pfp]);
            session(['student_id' => $student->student_id, 
                     'pfp' => $student->pfp, ]);
            
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

    public function updateProfilePage($student_id){
        $student = StudentAccount::where('student_id', $student_id)->first();
        return view('student-side.student-profile', compact('student'));
    }

    public function updateProfileForm($student_id){
        $student = StudentAccount::where('student_id', $student_id)->first();
        return view('student-side.update-profile', compact('student'));
    }

    public function updateProfile(Request $request, $student_id){
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
                $path = $request->file('pfp')->store('public/image/pfp');
                $validated['pfp'] = $path;
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

        
}
