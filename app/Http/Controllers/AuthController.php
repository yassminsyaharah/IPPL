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
        $active_navbar = 'login';

        return view ( 'auth.login', [ 
            'active_navbar' => $active_navbar
        ] );
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function index_register ()
    {
        $active_navbar = 'register';

        return view ( 'auth.register', [ 
            'active_navbar' => $active_navbar
        ] );
    }

    /**
     * Show the forgot password form.
     *
     * @return \Illuminate\View\View
     */
    public function forgot_password_index ()
    {
        $active_navbar = 'forgot-password';

        return view ( 'auth.forgot-password', [ 
            'active_navbar' => $active_navbar
        ] );
    }

    /**
     * Show the verify password form.
     *
     * @return \Illuminate\View\View
     */
    public function verify_password_index ()
    {
        $active_navbar = 'verify-password';

        return view ( 'auth.verify-password', [ 
            'active_navbar' => $active_navbar
        ] );
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

            if ( Auth::user ()->role == 'admin' )
            {
                return redirect ()->route ( 'admin.dashboard.index' )->with ( 'success', 'Login successful!' );
            }

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

        return redirect (  )->route('login')->with('success','Logout successful!');
    }

    /**
     * Handle sending the password reset link.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send_reset_link ( Request $request )
    {
        // Password reset logic here
        return back ()->with ( 'status', 'Password reset link sent!' );
    }

    /**
     * Handle password verification.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify_password ( Request $request )
    {
        // Verification logic here
        return redirect ( '/home' );
    }
}
