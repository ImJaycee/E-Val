<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use App\Mail\InstructorForgotPasswordMail;
use App\Models\InstructorAccount;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    

    public function sendResetLinkInstructor(Request $request)
    {
        // Validate the email address
        $request->validate([
            'instructor_id' => 'required',
        ]);
    
        $instructor_id = $request->instructor_id;
        // Check if the student ID exists and fetch the email if needed
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();
        if (!$instructor) {
            return back()->with('message', 'Instructor ID not found');
        } else {
            // Generate a random token
            $token =  rand(100000, 999999);
            // Update the student account with the token
            $instructor->password_reset_token = $token;
            $instructor->save();
    
            // Send the token to the user's email
            $email = $instructor->email;
            Mail::to($email)->send(new InstructorForgotPasswordMail($token));
    
            // return back()->with('message', 'Password reset link sent to your email');
            return redirect('/instructor-reset-password')->with('message', 'Password reset link sent to your email');
        }
    }

    public function resetPasswordInstructor(Request $request) // Reset password for instructor
    {
        // Validate the email address
        $validated = $request->validate([
            'instructor_id' => ['required'],
            'password' => ['required', 'min:8'],
            'password_reset_token' => ['required'],
        ]);
    
        $instructor_id = $request->instructor_id;
        $password = $request->password;
        $password_reset_token = $request->password_reset_token;
    
        // Check if the student ID exists and fetch the email if needed
        $instructor = InstructorAccount::where('instructor_id', $instructor_id)->first();
        if (!$instructor) {
            return back()->with('message', 'Instructor ID not found');
        } else {
            // Check if the token is correct
            if ($instructor->password_reset_token != $password_reset_token) {
                return back()->with('message', 'Invalid token');
            }
    
            // Update the student account with the new password
            $instructor->password = bcrypt($password);
            $instructor->password_reset_token = null;
            $instructor->save();
    
            return redirect('/')->with('message', 'Password reset successful');
        }
    }


    
}
