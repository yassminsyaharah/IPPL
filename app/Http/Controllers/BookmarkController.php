<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\BookmarkV2;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
{
    /**
     * Store a newly created bookmark in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store ( Request $request )
    {
        $request->validate ( [ 
            'destination_id' => 'required|exists:destinations,id',
        ] );

        $bookmark                 = new Bookmark();
        $bookmark->user_id        = Auth::id ();
        $bookmark->destination_id = $request->destination_id;
        $bookmark->save ();

        return redirect ()->back ()->with ( 'success', 'Bookmark added successfully.' );
    }

    public function storeV2 ( Request $request )
    {
        $request->validate ( [ 
            'place_id' => 'required|string',
        ] );

        $bookmark           = new BookmarkV2();
        $bookmark->user_id  = Auth::id ();
        $bookmark->place_id = $request->place_id;
        $bookmark->save ();

        return redirect ()->back ()->with ( 'success', 'Bookmark added successfully.' );
    }

    /**
     * Remove the specified bookmark from storage.
     *
     * @param  \App\Models\Bookmark  $bookmark
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy ( Bookmark $bookmark )
    {
        $bookmark->delete ();

        return redirect ()->back ()->with ( 'success', 'Bookmark removed successfully.' );
    }

    public function destroyV2 ( BookmarkV2 $bookmark )
    {
        $bookmark->delete ();
        return redirect ()->back ()->with ( 'success', 'Bookmark removed successfully.' );
    }
}