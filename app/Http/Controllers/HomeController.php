<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        $active_navbar = 'recommendations';
        return view (
            'recommendations',
            [ 
                'active_navbar' => $active_navbar,
            ]
        );
    }

    public function bookmarks_index ()
    {
        $active_navbar = 'bookmarks';
        return view (
            'bookmarks',
            [ 
                'active_navbar' => $active_navbar,
            ]
        );
    }
}
