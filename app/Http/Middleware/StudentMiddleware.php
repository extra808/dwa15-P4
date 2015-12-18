<?php

namespace ATC\Http\Middleware;

use Closure;
use Auth;
use Session;

class StudentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // authenticated user?
        if (Auth::check() ) {
            // user is student?
            if (Auth::user()->role != 'student') {
                Session::flash('flash_message', 'Student only');
                return redirect('/');
            }
        }
        else {
            return redirect('/');
        }

        return $next($request);
    }
}
