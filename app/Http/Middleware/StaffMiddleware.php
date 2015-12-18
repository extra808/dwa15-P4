<?php

namespace ATC\Http\Middleware;

use Closure;
use Auth;
use Session;
use Log;

class StaffMiddleware
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
            // user is staff?
            if (Auth::user()->role != 'staff') {
                Session::flash('flash_message', 'Staff only');
                return redirect('/');
            }
        }
        else {
            return redirect('/');
        }

        return $next($request);
    }
}
