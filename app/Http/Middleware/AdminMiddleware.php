<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle ( Request $request, Closure $next ) : Response
    {
        // Jika user terautentikasi dan memiliki peran admin, lanjutkan ke rute yang diminta
        if ( auth ()->check () && auth ()->user ()->role === "admin" )
        {
            return $next ( $request );
        }

        // Jika user tidak terautentikasi atau bukan admin, arahkan ke rute login
        return redirect ( "/" )->with ( "error", "Unauthorized access" );
    }
}
