<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function onboarding_index ()
    {
        $destinations  = Destination::orderBy ( 'updated_at', 'desc' )->take ( 2 )->get ();
        $bookmarks     = collect ( [] );
        $active_navbar = 'onboarding';

        if ( Auth::check () )
        {
            $bookmarks = Auth::user ()->bookmarks ()
                ->with ( 'destination' )
                ->orderBy ( 'updated_at', 'desc' )
                ->take ( 2 )
                ->get ();
        }

        return view (
            'onboarding',
            [ 
                'active_navbar' => $active_navbar,
                'destinations'  => $destinations,
                'bookmarks'     => $bookmarks,
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
        $bookmarks     = [];

        if ( Auth::check () )
        {
            $bookmarks = Auth::user ()->bookmarks ()->with ( 'destination' )->get ();
        }

        return view (
            'bookmarks',
            [ 
                'active_navbar' => $active_navbar,
                'bookmarks'     => $bookmarks,
            ]
        );
    }

    public function search ( Request $request )
    {
        $query = $request->get ( 'query' );

        if ( empty ( trim ( $query ) ) )
        {
            if ( $request->ajax () )
            {
                return response ()->json ( [ 
                    'html' => view ( 'components.search-default-message' )->render ()
                ] );
            }
            return redirect ()->back ();
        }

        $destinations = Destination::where ( 'name', 'like', "%{$query}%" )
            ->orWhere ( 'description', 'like', "%{$query}%" )
            ->orWhere ( 'address', 'like', "%{$query}%" )
            ->take ( 2 )
            ->get ();

        if ( $request->ajax () )
        {
            return response ()->json ( [ 
                'data' => $destinations,
                'html' => view ( 'components.search-results', [ 'destinations' => $destinations ] )->render ()
            ] );
        }

        return redirect ()->back ();
    }
}
