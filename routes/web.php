<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PlaceController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\DashboardAdminController;
use App\Http\Controllers\IntelligentSystemController;

// Onboarding Routes
Route::get (
    '/',
    [ HomeController::class, 'onboarding_index' ]
)->name ( 'onboarding' );

Route::get (
    '/home',
    [ HomeController::class, 'onboarding_index' ]
)->name ( 'home' );

// Recommendation Routes
Route::get (
    '/recommendations',
    [ HomeController::class, 'recommendations_index' ]
)->name ( 'recommendations' );

// Bookmark Routes
Route::get (
    '/bookmarks',
    [ HomeController::class, 'bookmarks_index' ]
)->name ( 'bookmarks' );

Route::post ( '/bookmarks', [ BookmarkController::class, 'store' ] )->name ( 'bookmarks.store' );

Route::delete ( '/bookmarks/{bookmark}', [ BookmarkController::class, 'destroy' ] )->name ( 'bookmarks.destroy' );

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
Route::get (
    '/forgot-password',
    [ AuthController::class, 'forgot_password_index' ]
)->name ( 'forgot.password' );

Route::post (
    '/forgot-password',
    [ AuthController::class, 'send_reset_link' ]
)->name ( 'password.email' );

Route::get (
    '/verify-password',
    [ AuthController::class, 'verify_password_index' ]
)->name ( 'verify.password' );

Route::post (
    '/verify-password',
    [ AuthController::class, 'verify_password' ]
)->name ( 'verification.verify' );

Route::post ( '/resend-verification', function ()
{
    // Resend verification code logic here
    return back ()->with ( 'status', 'Verification link sent!' );
} )->name ( 'verification.resend' );

// Place Routes
Route::middleware ( 'CheckIfAuth' )
    ->group ( function ()
    {
        Route::get (
            '/place/{id}',
            [ PlaceController::class, 'show' ]
        )->name ( 'place.detail' );
    } );

// Add this temporary debug route
Route::get ( '/storage-test', function ()
{
    $path = 'destinations/676f6088c2640';
    return [ 
        'storage_path' => storage_path ( 'app/public/' . $path ),
        'exists'       => Storage::exists ( 'public/' . $path ),
        'files'        => Storage::exists ( 'public/' . $path ) ? Storage::files ( 'public/' . $path ) : [],
        'all_files'    => Storage::allFiles ( 'public' ),
        'directories'  => Storage::directories ( 'public' ),
    ];
} );

Route::get ( '/test-storage', function ()
{
    // Create a test file
    Storage::disk ( 'public' )->put ( 'test.txt', 'Hello World' );

    return [ 
        'file_exists'  => Storage::disk ( 'public' )->exists ( 'test.txt' ),
        'file_url'     => Storage::disk ( 'public' )->url ( 'test.txt' ),
        'storage_path' => storage_path ( 'app/public' ),
        'public_path'  => public_path ( 'storage' ),
        'is_linked'    => file_exists ( public_path ( 'storage' ) ),
    ];
} );

// Search Route
Route::get (
    '/search',
    [ HomeController::class, 'search' ]
)->name ( 'search' );

// Subscription Route
Route::post ( '/subscribe', [ SubscriptionController::class, 'subscribe' ] )->name ( 'subscribe' );

// User Dashboard Routes
Route::middleware ( [ 'CheckIfUser' ] )
    ->prefix ( 'user/dashboard' )
    ->as ( 'user.dashboard.' )
    ->group ( function ()
    {
        Route::get ( '/', function ()
        {
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

// Intelligent System Routes (Google Places API)
Route::middleware ( 'CheckIfAuth' )
    ->group ( function ()
    {
        Route::get (
            '/surfing',
            [ IntelligentSystemController::class, 'surfing_index' ]
        )->name ( 'surfing' );

        Route::get (
            '/trekking',
            [ IntelligentSystemController::class, 'trekking_index' ]
        )->name ( 'trekking' );

        Route::get (
            '/multiactivity',
            [ IntelligentSystemController::class, 'multiactivity_index' ]
        )->name ( 'multiactivity' );

        Route::get (
            '/outbond',
            [ IntelligentSystemController::class, 'outbond_index' ]
        )->name ( 'outbond' );

        Route::get (
            '/place_v2/{placeId}',
            [ IntelligentSystemController::class, 'showPlaceDetail' ]
        )->name ( 'place.detail_v2' );

        Route::get (
            '/borobudur-attractions',
            [ IntelligentSystemController::class, 'showBorobudurAttractions' ]
        )->name ( 'borobudur.attractions' );

        Route::get (
            '/pandawa-attractions',
            [ IntelligentSystemController::class, 'showPandawaAttractions' ]
        )->name ( 'pandawa.attractions' );

        Route::get (
            '/tebing-keraton-attractions',
            [ IntelligentSystemController::class, 'showTebingKeratonAttractions' ]
        )->name ( 'tebingkeraton.attractions' );

        Route::get (
            '/monas-attractions',
            [ IntelligentSystemController::class, 'showMonasAttractions' ]
        )->name ( 'monas.attractions' );
    } );

Route::middleware ( 'auth' )->group ( function ()
{
    Route::post (
        '/bookmarksv2',
        [ BookmarkController::class, 'storeV2' ]
    )->name ( 'bookmarks.storeV2' );

    Route::delete (
        '/bookmarksv2/{bookmark}',
        [ BookmarkController::class, 'destroyV2' ]
    )->name ( 'bookmarks.destroyV2' );
} );
