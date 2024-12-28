<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Onboarding Routes
Route::get ( '/', function ()
{
    return view ( 'onboarding' );
} )->name ( 'onboarding' );

Route::get ( '/home', function ()
{
    return redirect ()->route ( 'onboarding' );
} )->name ( 'home' );

// Recommendation Routes
Route::get ( '/recommendations', function ()
{
    return view ( 'recommendations' );
} )->name ( 'recommendations' );

// Bookmark Routes
Route::get ( '/bookmarks', function ()
{
    return view ( 'bookmarks' );
} )->name ( 'bookmarks' );

// Authentication Routes
Route::get (
    '/login',
    [ AuthController::class, 'login_index' ]
)->name ( 'login' );

Route::post (
    '/login',
    [ AuthController::class, 'login' ]
)->name ( 'login.post' );

Route::post (
    '/logout',
    [ AuthController::class, 'logout' ]
)->name ( 'logout' );

Route::get (
    '/register',
    [ AuthController::class, 'index_register' ]
)->name ( 'register' );

Route::post (
    '/register',
    [ AuthController::class, 'register' ]
);

// Password Routes
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

// Place Routes
Route::get ( '/place/{id}', function ($id)
{
    return view ( 'place-detail', [ 'id' => $id ] );
} )->name ( 'place.detail' );

// Dashboard Routes
Route::middleware ( [ 'RedirectIfAuthenticated' ] )->prefix ( 'dashboard' )->group ( function ()
{
    Route::get ( '/', function ()
    {
        return view ( 'dashboard.index' );
    } )->name ( 'dashboard' );

    Route::get ( '/profile', function ()
    {
        return view ( 'dashboard.profile' );
    } )->name ( 'dashboard.profile' );

    Route::get ( '/settings', function ()
    {
        return view ( 'dashboard.settings' );
    } )->name ( 'dashboard.settings' );

    Route::get ( '/analytics', function ()
    {
        return view ( 'dashboard.analytics' );
    } )->name ( 'dashboard.analytics' );

    Route::get ( '/bookmarks', function ()
    {
        return view ( 'dashboard.bookmarks' );
    } )->name ( 'dashboard.bookmarks' );
} );
