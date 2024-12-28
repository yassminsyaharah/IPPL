<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\DestinationController;

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
Route::middleware ( [ 'guest.middleware' ] )->group ( function ()
{
    Route::get (
        '/login',
        [ AuthController::class, 'login_index' ]
    )->name ( 'login' );

    Route::post (
        '/login',
        [ AuthController::class, 'login' ]
    )->name ( 'login.post' );

    Route::get (
        '/register',
        [ AuthController::class, 'index_register' ]
    )->name ( 'register' );

    Route::post (
        '/register',
        [ AuthController::class, 'register' ]
    );
} );

Route::post (
    '/logout',
    [ AuthController::class, 'logout' ]
)->name ( 'logout' );

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

// Add this temporary debug route
Route::get('/storage-test', function() {
    $path = 'destinations/676f6088c2640';
    return [
        'storage_path' => storage_path('app/public/' . $path),
        'exists' => Storage::exists('public/' . $path),
        'files' => Storage::exists('public/' . $path) ? Storage::files('public/' . $path) : [],
        'all_files' => Storage::allFiles('public'),
        'directories' => Storage::directories('public'),
    ];
});

// User Dashboard Routes
Route::middleware ( [ 'CheckIfUser' ] )
    ->prefix ( 'user/dashboard' )
    ->as ( 'user.dashboard.' )
    ->group ( function ()
    {
        Route::get ( '/', function ()
        {
            dd ( "SSS" );
            return view ( 'dashboard.user.index' );
        } )->name ( 'index' );

        Route::get ( '/profile', function ()
        {
            return view ( 'dashboard.user.profile' );
        } )->name ( 'profile' );

        Route::get ( '/settings', function ()
        {
            return view ( 'dashboard.user.settings' );
        } )->name ( 'settings' );

        Route::get ( '/bookmarks', function ()
        {
            return view ( 'dashboard.user.bookmarks' );
        } )->name ( 'bookmarks' );
    } );

// Admin Dashboard Routes
Route::middleware ( 'CheckIfAdmin' )
    ->prefix ( 'admin/dashboard' )
    ->as ( 'admin.dashboard.' )
    ->group ( function ()
    {
        Route::get (
            '/',
            [ DashboardAdminController::class, 'index' ]
        )->name ( 'index' );

        Route::get (
            '/analytics',
            [ DashboardAdminController::class, 'analytics' ]
        )->name ( 'analytics' );

        Route::get (
            '/settings',
            [ DashboardAdminController::class, 'settings' ]
        )->name ( 'settings' );

        Route::post (
            '/destinations',
            [ DestinationController::class, 'store' ]
        )->name ( 'destinations.store' );

        Route::put (
            '/destinations/{destination}',
            [ DestinationController::class, 'update' ]
        )->name ( 'destinations.update' );

        Route::delete (
            '/destinations/{destination}',
            [ DestinationController::class, 'destroy' ]
        )->name ( 'destinations.destroy' );
    } );