<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle ( Request $request, Closure $next ) : Response
    {
        // Jika user terautentikasi, arahkan ke rute onboarding
        if ( auth ()->check () && auth ()->user ()->role === "user" )
        {
            return $next ( $request );
        }

        // Jika user tidak terautentikasi, arahkan ke rute login
        return redirect ( "/" )->with ( "error", "Unauthorized access" );
    }
}
