<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

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
        Route::get('/student-profile', function () {
            return view('student-side.student-profile');
        })->name('student.profile');
    });

    //Student Profile
   
});






