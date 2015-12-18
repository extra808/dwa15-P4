<?php

use SocialNorm\Exceptions\ApplicationRejectedException;
use SocialNorm\Exceptions\InvalidAuthorizationCodeException;

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/google/authorize', function() {
    return SocialAuth::authorize('google');
});

Route::get('/google/login', function() {
    try {
        SocialAuth::login('google', function ($user, $userDetails) {
            // is "host domain" correct?
            if ($userDetails->raw['hd'] == 'cognize.org') {
                // is user staff?
                if ($staffCheck = \ATC\Staff::where('external_id', '=', $userDetails->email) ->first() ) {
                    $user->email = $userDetails->email;
                    $user->name = $userDetails->full_name;
                    $user->role = 'staff';
                    $user->save();
                }
                // is user student?
                elseif ($studentCheck = \ATC\Student::where('external_id', '=', $userDetails->email) ->first() ) {
                    $user->email = $userDetails->email;
                    $user->name = $userDetails->full_name;
                    $user->role = 'student';
                    $user->save();
                }
                else {
                    Session::flash('flash_message', 'No such user');
                    abort(403, 'Forbbiden');
                }
            }
            else {
                Session::flash('flash_message', 'Domain not allowed');
                abort(403, 'Forbbiden');
            }
        });
    }
    catch (ApplicationRejectedException $e) {
        // User rejected application
        Session::flash('flash_message', 'User rejected application');
        abort(403, 'Forbbiden');
    }
    catch (InvalidAuthorizationCodeException $e) {
        // Authorization was attempted with invalid
        // code,likely forgery attempt
        Session::flash('flash_message', 'Authorization was attempted with invalid code');
        abort(403, 'Forbbiden');
    }

    return Redirect::intended();
});

// Home page
Route::get('/', function () {
    if (Auth::guest() ) {
        return view('layouts.guest');
    }
    // is authenticated user a student?
    elseif (Auth::user()->role == 'student') {
        // get id of logged in student
        $student = ATC\Student::where('external_id', '=', Auth::user()->email)->get() ->first() ->id;
        
        // show student's information, i.e. course list
        $studentController = new ATC\Http\Controllers\StudentController;
        return $studentController->show($student);
    }
    // staff home page, lists students
    else {
        $studentController = new ATC\Http\Controllers\StudentController;
        return $studentController->index();
    }
});

// For individual students
Route::group(['middleware' => 'ATC\Http\Middleware\StudentMiddleware'], function()
{
    Route::get('/courses/{id}', 'CourseController@showStudentCourse');
    Route::get('/courses/{courseId}/files/{id}', 'FileController@showStudentCourseFile');
});

Route::get('/logout', 'Auth\AuthController@getLogout');

// only use Laravel Log Viewer in a local environment
if (App::environment() == 'local') {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}


// Staff only
Route::group(['middleware' => 'ATC\Http\Middleware\StaffMiddleware'], function()
{
    Route::resource('students', 'StudentController');

    Route::resource('students.courses', 'CourseController');

    Route::resource('students.courses.files', 'FileController');
});

