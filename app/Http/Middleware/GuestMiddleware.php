<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GuestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle ( Request $request, Closure $next )
    {
        if ( Auth::check () )
        {
            return redirect ( '/' )->with ( 'warning', 'You are already logged in.' );
        }

        return $next ( $request );
    }
}
