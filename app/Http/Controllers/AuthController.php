<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form.
     *
     * @return \Illuminate\View\View
     */
    public function login_index ()
    {
        return view ( 'auth.login' );
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function index_register ()
    {
        return view ( 'auth.register' );
    }

    /**
     * Handle a login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login ( Request $request )
    {
        $credentials = $request->validate ( [ 
            'email'    => [ 'required', 'email' ],
            'password' => [ 'required' ],
        ] );

        // Add remember me functionality
        $remember = $request->has ( 'remember' );

        if ( Auth::attempt ( $credentials, $remember ) )
        {
            $request->session ()->regenerate ();

            return redirect ()->route ( 'onboarding' )->with ( 'success', 'Login successful!' );
        }

        return back ()->withErrors ( [ 
            'email' => 'The provided credentials do not match our records.',
        ] )->onlyInput ( 'email' );
    }

    /**
     * Handle a registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function register ( Request $request )
    {
        // Validate request data
        $validated = $request->validate ( [ 
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'terms'    => 'required|in:on,1',
        ] );

        // Create new user
        $user = User::create ( [ 
            'name'         => $validated[ 'name' ],
            'email'        => $validated[ 'email' ],
            'phone_number' => $validated[ 'phone' ],
            'password'     => Hash::make ( $validated[ 'password' ] ),
            'role'         => 'user'
        ] );

        // Login the user
        // Auth::login ( $user );

        return redirect ()->route ( 'login' )
            ->with ( 'success', 'Registration successful! Welcome to Travelin.' );
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout ( Request $request )
    {
        Auth::logout ();

        $request->session ()->invalidate ();
        $request->session ()->regenerateToken ();

        return redirect ( '/login' );
    }
}
