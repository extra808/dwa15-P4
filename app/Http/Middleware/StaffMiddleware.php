<?php

namespace ATC\Http\Middleware;

use Closure;
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
        if ($request->has('user') ) {
            // user is staff?
            if ($request->user()->role != 'staff') {
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
