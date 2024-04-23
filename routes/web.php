<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Http\Request;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\InstructorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('index');
})->name('view.index');

Route::get('/forgot-passsword-form', function () {//forgot-passsword-form
    return view('mail.User-Email-Password');
})->name('student.forgot-passsword-form');

Route::controller(ForgotPasswordController::class)->group(function(){
    Route::post('/forgot-passsword', 'sendResetLink')->name('sendResetLink');
    Route::post('/reset-password', 'resetPassword')->name('resetPassword');
});
Route::get('/reset-password', function () {//forgot-passsword-form
    return view('mail.Reset-Password');
})->name('student.reset-passsword');


//Student Side
// Create student registration route
Route::get('/register-student', function () {
    return view('student-side.register');
})->name('register.student');

// Student Part
Route::controller(StudentController::class)->group(function(){
    Route::post('/register-student', 'registerStudent')->name('registerStudent'); //register process
    Route::post('/studentlogin-process', 'Student_loginprocess')->name('Student_loginprocess'); //login process
    Route::get('/student-dashboard', 'Student_dashboard')->name('student.dashboard')->middleware('auth:students'); 
    Route::post('/student-logout', 'logout')->name('logout'); // Protect the logout route


    Route::group(['middleware' => 'auth:students'], function () { 
        //Student Profile Side
        //Route::get('/student-profile', function () { return view('student-side.student-profile');})->name('student.profile');
        Route::get('/student-profile{student_id}', 'updateProfilePage')->name('student.profile');
        // Route::get('/student-update-profile', function () { return view('student-side.update-profile'); })->name('student.update-profile');
        Route::get('/student-update-profile{student_id}', 'updateProfileForm')->name('student-side.update-profile-form');
        Route::post('/student-update-profile{student_id}', 'updateProfile')->name('student-side.update-profile-process');
        Route::post('/student-change-password{student_id}', 'changePassword')->name('student-side.change-password');

        //Student evaluation
        Route::get('/student-evaluation', function () {
            return view('student-side.student-evaluation');
        })->name('student.evaluation');

        //Student view instructors rank
        Route::get('/student-instructor-rank', function () {
            return view('student-side.student-instructors-rank');
        })->name('student.instructor-rank');

        //Student feedback
        Route::get('/student-feedback', function () {
            return view('student-side.student-feedback');
        })->name('student.feedback');

        
    });

    //Student Profile
   
}); // end of student part (Controller)


//Instructor Side
// Create student registration route
Route::get('/register-instructor', function () {
    return view('instructor-side.register');
})->name('register.instructor');

// Instructor Part
Route::controller(InstructorController::class)->group(function(){
    Route::post('/register-instructor', 'registerInstructor')->name('registerInstructor'); //register process
    Route::post('/instructorlogin-process', 'Instructor_loginprocess')->name('Instructor_loginprocess'); //login process
    Route::get('/instructor-dashboard', 'Instructor_dashboard')->name('instructor.dashboard')->middleware('auth:instructors'); 
    Route::post('/instructor-logout', 'logout')->name('instructor_logout'); // Protect the logout route

    Route::group(['middleware' => 'auth:instructors'], function () { 
        // Instructor Profile Management
        Route::get('/instructor-profile{instructor_id}', 'updateProfilePage')->name('instructor.profile');
        Route::get('/instructor-update-profile{instructor_id}', 'updateProfileForm')->name('instructor-side.update-profile-form');
        Route::post('/instructor-update-profile{instructor_id}', 'updateProfile')->name('instructor-side.update-profile-process');
        Route::post('/instructor-change-password{instructor_id}', 'changePassword')->name('instructor-side.change-password');

        //Instructor evaluation P2P Side
        Route::get('/instructor-evaluation', function () {
            return view('instructor-side.instructor-evaluation');
        })->name('instructor.evaluation');

        // view instructors rank
        Route::get('/instructor-instructor-rank', function () {
            return view('instructor-side.instructor-instructors-rank');
        })->name('instructor.instructor-rank');

        //Comments for instructor
        Route::get('/instructor-students-comment', function () {
            return view('instructor-side.instructor-comments');
        })->name('instructor.comments');


        //Instructor feedback
        Route::get('/instructor-feedback', function () {
            return view('instructor-side.instructor-feedback');
        })->name('instructor.feedback');

    }); //end of authenticated routes

}); // end of instructor part (Controller)





