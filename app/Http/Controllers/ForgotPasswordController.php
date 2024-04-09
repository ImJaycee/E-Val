<?php

namespace App\Http\Controllers;

use App\Models\StudentAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;

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
        }else{
            $email = $student->email;
            Mail::to($email)->send(new ForgotPasswordMail());
            return back()->with('message', 'Password reset link sent to your email');
        } 

      

       
    }
}
