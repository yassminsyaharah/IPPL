<?php

use Illuminate\Support\Facades\Route;

Route::get ( '/', function ()
{
    return view ( 'onboarding' );
} );

Route::get ( '/recommendations', function ()
{
    return 'Recommendations Page';
} );

Route::get ( '/bookmarks', function ()
{
    return 'Bookmarks Page';
} );

Route::get ( '/home', function ()
{
    return 'Home Page';
} );

Route::get ( '/login', function ()
{
    return 'Login Page';
} )->name ( 'login' );

Route::get ( '/register', function ()
{
    return 'Register Page';
} )->name ( 'register' );

Route::post ( '/logout', function ()
{
    return 'Logged out';
} )->name ( 'logout' );
