<?php

namespace App\Http\Controllers;

use App\Models\InstructorAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            "department" => ['required', 'string'],
            "password" => ['required', 'string', 'min:8', 'confirmed'],
        ]);
               

        
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
            
            session(['instructor_id' => $instructor->instructor_id, 
                     'firstname' => $instructor->firstname,
                     'pfp' => $instructor->pfp, ]);
            
            return redirect("/instructor-dashboard")->with('message', 'Welcome Back!');//return redirect to dashboard
        }else {
          
            return redirect("/")->with('message', 'Invalid Credentials!');//return redirect to dashboard
          
        }   

        return back()->withErrors([ //login failed
            'instructor_id' => 'Invalid Credentials'
        ])->withInput(); //return back to login page
            
    } // end login process

    public function Instructor_dashboard(){ //Instructor dashboard
        return view('instructor-side.instructor-dashboard');
    }

    public function logout(Request $request){//logout
        auth()->guard('instructors')->logout(); 
        $request->session()->invalidate(); //invalidate session
        $request->session()->regenerateToken(); //regenerate token
        return redirect('/')
        ->with('message', 'Logged out')
        ->header('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
        ->header('Pragma', 'no-cache');
    }

    public function updateProfilePage($instructor_id){ //update profile page
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();
        return view('instructor-side.instructor-profile', compact('instructor'));
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
            "oldpassword" => ['required', 'min:8'],
            "newpassword" => ['required', 'min:8'],
            "con_pass" => ['required', 'min:8'],
        ]);
        // dd($validated);

        if($validated['newpassword'] !== $validated['con_pass']){
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


}
