<?php

use Illuminate\Support\Facades\Route;

Route::get ( '/', function ()
{
    return view ( 'onboarding' );
} )->name ( 'onboarding' );

Route::get ( '/recommendations', function ()
{
    return view ( 'recommendations' );
} )->name ( 'recommendations' );

Route::get ( '/bookmarks', function ()
{
    return view ( 'bookmarks' );
} )->name ( 'bookmarks' );

Route::get ( '/home', function ()
{
    return redirect ()->route ( 'onboarding' );
} )->name ( 'home' );

Route::get ( '/login', function ()
{
    return view ( 'auth.login' );
} )->name ( 'login' );

Route::get ( '/register', function ()
{
    return view ( 'auth.register' );
} )->name ( 'register' );

Route::post ( '/logout', function ()
{
    return 'Logged out';
} )->name ( 'logout' );

Route::get ( '/forgot-password', function ()
{
    return view ( 'auth.forgot-password' );
} )->name ( 'forgot.password' );

Route::post ( '/forgot-password', function ()
{
    // Password reset logic here
    return back ()->with ( 'status', 'Password reset link sent!' );
} )->name ( 'password.email' );

Route::get ( '/verify-password', function ()
{
    return view ( 'auth.verify-password' );
} )->name ( 'verify.password' );

Route::post ( '/verify-password', function ()
{
    // Verification logic here
    return redirect ( '/home' );
} )->name ( 'verification.verify' );

Route::post ( '/resend-verification', function ()
{
    // Resend verification code logic here
    return back ()->with ( 'status', 'Verification link sent!' );
} )->name ( 'verification.resend' );
