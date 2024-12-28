<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;

class PlaceController extends Controller
{
    public function show ( $id )
    {
        $place        = Destination::findOrFail ( $id );
        $isBookmarked = false;
        $bookmarkId   = null;

        if ( Auth::check () )
        {
            $bookmark     = Auth::user ()->bookmarks ()->where ( 'destination_id', $place->id )->first ();
            $isBookmarked = $bookmark ? true : false;
            $bookmarkId   = $bookmark ? $bookmark->id : null;
        }

        return view ( 'place-detail', [ 
            'place'        => $place,
            'isBookmarked' => $isBookmarked,
            'bookmarkId'   => $bookmarkId
        ] );
    }
}
