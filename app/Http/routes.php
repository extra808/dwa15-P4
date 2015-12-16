<?php

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

Route::get('/authorize', function() {
    return SocialAuth::authorize('google');
});

Route::get('google/login', function() {
    $userDeets;
    SocialAuth::login('google', function ($user, $userDetails) {
        if($userDetails->email == 'cwilcox@cognize.org') {
            dd($userDetails);
        }
        else {
            Session::flash('flash_message', $userDetails->email .' not allowed to access this application');
            abort(403, 'Forbbiden');
 
        }
    });
    return 'Google authorized';
});

Route::get('/', function () {
    return view('layouts.master');
});

// only use Laravel Log Viewer in a local environment
if (App::environment() == 'local') {
    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');
}

Route::resource('students', 'StudentController');

Route::resource('students.courses', 'CourseController');

Route::resource('students.courses.files', 'FileController');
