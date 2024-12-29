<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle ( Request $request, Closure $next ) : Response
    {
        // Jika user terautentikasi dan memiliki peran admin atau user, lanjutkan ke rute yang diminta
        if ( auth ()->check () && ( auth ()->user ()->role === "admin" || auth ()->user ()->role === "user" ) )
        {
            return $next ( $request );
        }

        // Jika user tidak terautentikasi atau bukan admin/user, arahkan ke rute login
        return redirect ( "/login" )->with ( "error", "Please Login first" );
    }
}
