<?php

namespace App\Http\Controllers\Admin;

use App\Models\Destination;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function index ()
    {
        $destinations = Destination::latest ()->paginate ( 10 );
        return view ( 'admin.dashboard', compact ( 'destinations' ) );
    }

    public function store ( Request $request )
    {
        $validated = $request->validate ( [ 
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'address'         => 'required|string',
            'province'        => 'required|string',
            'operating_hours' => 'required|string',
            'image'           => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ] );

        if ( $request->hasFile ( 'image' ) )
        {
            $image                  = $request->file ( 'image' );
            $path                   = $image->store ( 'destinations', 'public' );
            $validated[ 'image_url' ] = $path;
        }

        Destination::create ( $validated );

        return redirect ()->route ( 'admin.dashboard' )->with ( 'success', 'Destination created successfully' );
    }

    public function update ( Request $request, Destination $destination )
    {
        $validated = $request->validate ( [ 
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'address'         => 'required|string',
            'province'        => 'required|string',
            'operating_hours' => 'required|string',
            'image'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ] );

        if ( $request->hasFile ( 'image' ) )
        {
            if ( $destination->image_url )
            {
                Storage::disk ( 'public' )->delete ( $destination->image_url );
            }
            $image                  = $request->file ( 'image' );
            $path                   = $image->store ( 'destinations', 'public' );
            $validated[ 'image_url' ] = $path;
        }

        $destination->update ( $validated );

        return redirect ()->route ( 'admin.dashboard' )->with ( 'success', 'Destination updated successfully' );
    }

    public function destroy ( Destination $destination )
    {
        if ( $destination->image_url )
        {
            Storage::disk ( 'public' )->delete ( $destination->image_url );
        }

        $destination->delete ();
        return redirect ()->route ( 'admin.dashboard' )->with ( 'success', 'Destination deleted successfully' );
    }
}
