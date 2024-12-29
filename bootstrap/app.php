<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\UserMiddleware;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure ( basePath: dirname ( __DIR__ ) )
    ->withRouting (
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware ( function (Middleware $middleware)
    {
        //
    } )
    ->withExceptions ( function (Exceptions $exceptions)
    {
        //
    } )
    ->withMiddleware ( function (Middleware $middleware)
    {
        $middleware->alias ( [ 
            'CheckIfAdmin'            => AdminMiddleware::class,
            'CheckIfUser'             => UserMiddleware::class,
            'CheckIfAuth'             => AuthMiddleware::class,
            'guest.middleware'        => GuestMiddleware::class,
            'RedirectIfAuthenticated' => RedirectIfAuthenticated::class,
        ] );
    } )
    ->create ();
