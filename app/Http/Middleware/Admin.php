<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
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
        if (Auth::user()->admin) {
            return $next($request);
        }
        $notification = array(
            'message' => 'You do not have permission to access this link.',
            'alert-type' => 'error'
        );
        return redirect('/login')->with($notification);
    }
}
