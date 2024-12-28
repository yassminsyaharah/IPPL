<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;
use Illuminate\Support\Facades\Storage;

class DestinationController extends Controller
{
    public function store ( Request $request )
    {
        $request->validate ( [ 
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'address'         => 'required|string',
            'province'        => 'required|string',
            'operating_hours' => 'required|string',
            'ratings'         => 'required|numeric|min:0|max:5',
            'images.*'        => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'review_count'    => 'required|integer|min:0',
        ] );

        $data = $request->except ( 'images' );

        if ( $request->hasFile ( 'images' ) )
        {
            $folderPath = 'destinations/' . uniqid ();

            foreach ( $request->file ( 'images' ) as $image )
            {
                $image->store ( $folderPath, 'public' );
            }

            $data[ 'image_folder_path' ] = $folderPath;
        }

        Destination::create ( $data );

        return redirect ()->route ( 'admin.dashboard.index' )
            ->with ( 'success', 'Destination created successfully.' );
    }

    public function update ( Request $request, Destination $destination )
    {
        $request->validate ( [ 
            'name'            => 'required|string|max:255',
            'description'     => 'required|string',
            'address'         => 'required|string',
            'province'        => 'required|string',
            'operating_hours' => 'required|string',
            'ratings'         => 'required|numeric|min:0|max:5', // Add this line
            'images.*'        => 'nullable|image|max:2048',
            'review_count'    => 'required|integer|min:0',
        ] );

        $destination->fill ( $request->except ( 'images' ) );

        if ( $request->hasFile ( 'images' ) )
        {
            // Delete old folder if exists
            if ( $destination->image_folder_path )
            {
                Storage::disk ( 'public' )->deleteDirectory ( $destination->image_folder_path );
            }

            $folderPath = 'destinations/' . uniqid ();
            foreach ( $request->file ( 'images' ) as $image )
            {
                $image->store ( $folderPath, 'public' );
            }
            $destination->image_folder_path = $folderPath;
        }

        $destination->save ();

        return redirect ()->route ( 'admin.dashboard.index' )->with ( 'success', 'Destination updated successfully.' );
    }

    public function destroy ( Destination $destination )
    {
        if ( $destination->image_folder_path )
        {
            Storage::disk ( 'public' )->deleteDirectory ( $destination->image_folder_path );
        }

        $destination->delete ();

        return redirect ()->route ( 'admin.dashboard.index' )->with ( 'success', 'Destination deleted successfully.' );
    }
}
