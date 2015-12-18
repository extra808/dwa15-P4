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

Route::get('/github/authorize', function() {
    return SocialAuth::authorize('github');
});

Route::get('github/login', function() {
    try {
        SocialAuth::login('github', function ($user, $userDetails) {

            $nameCheck = '';
            $userCheck;
            // get authenticated user's name
            if($userDetails->full_name) {
                $nameCheck = $userDetails->full_name;
            }
            else {
                $nameCheck = $userDetails->nickname;
            }

            // is name in database?
            if ($userCheck = \ATC\User::where('name', '=', $nameCheck) ->first() ) {
                if ($userCheck->name == 'extra808') {
                    $user->email = $userDetails->email;
                    $user->save();
                }
                else {
                    Session::flash('flash_message', 'You are not staff');
                    abort(403, 'Forbbiden');
                }
            }
            else {
                Session::flash('flash_message', 'No such user');
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

    // Current user is now available via Auth facade
    $user = Auth::user();

    dd($user);
    dd($userDetails);

    return Redirect::intended();
});

Route::get('/google/authorize', function() {
    return SocialAuth::authorize('google');
});

Route::get('/google/login', function() {
    try {
        SocialAuth::login('google', function ($user, $userDetails) {
            // is "host domain" correct?
            if($userDetails->raw['hd'] == 'cognize.org') {
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

    // Current user is now available via Auth facade
//    $user = Auth::user();

    return Redirect::intended();
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
