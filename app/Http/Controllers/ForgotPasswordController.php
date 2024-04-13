<?php

namespace App\Http\Controllers;

use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function sendResetLink(Request $request)
    {
        // Validate the email address
        $request->validate([
            'student_id' => 'required',
        ]);
    
        $student_id = $request->student_id;
        // Check if the student ID exists and fetch the email if needed
        $student = StudentAccount::where('student_id', $student_id)->first();
        if (!$student) {
            return back()->with('message', 'Student ID not found');
        } else {
            // Generate a random token
            $token =  rand(100000, 999999);
            // Update the student account with the token
            $student->password_reset_token = $token;
            $student->save();
    
            // Send the token to the user's email
            $email = $student->email;
            Mail::to($email)->send(new ForgotPasswordMail($token));
    
            // return back()->with('message', 'Password reset link sent to your email');
            return redirect('/reset-password')->with('message', 'Password reset link sent to your email');
        }
    }

    public function resetPassword(Request $request) // Reset password
    {
        // Validate the email address
        $validated = $request->validate([
            'student_id' => 'required',
            'password' => 'required',
            'password_reset_token' => 'required',
        ]);
    
        $student_id = $request->student_id;
        $password = $request->password;
        $password_reset_token = $request->password_reset_token;
    
        // Check if the student ID exists and fetch the email if needed
        $student = StudentAccount::where('student_id', $student_id)->first();
        if (!$student) {
            return back()->with('message', 'Student ID not found');
        } else {
            // Check if the token is correct
            if ($student->password_reset_token != $password_reset_token) {
                return back()->with('message', 'Invalid token');
            }
    
            // Update the student account with the new password
            $student->password = bcrypt($password);
            $student->password_reset_token = null;
            $student->save();
    
            return redirect('/')->with('message', 'Password reset successful');
        }
    }
    
}
