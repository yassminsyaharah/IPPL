<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function onboarding_index ()
    {
        $active_navbar = 'onboarding';
        return view (
            'onboarding',
            [ 
                'active_navbar' => $active_navbar,
            ]
        );
    }

    public function recommendations_index ()
    {
        $destinations  = Destination::all ();
        $active_navbar = 'recommendations';
        return view (
            'recommendations',
            [ 
                'destinations'  => $destinations,
                'active_navbar' => $active_navbar,
            ]
        );
    }

    public function bookmarks_index ()
    {
        $active_navbar = 'bookmarks';
        $bookmarks     = Auth::user ()->bookmarks ()->with ( 'destination' )->get ();
        return view (
            'bookmarks',
            [ 
                'active_navbar' => $active_navbar,
                'bookmarks'     => $bookmarks,
            ]
        );
    }
}
