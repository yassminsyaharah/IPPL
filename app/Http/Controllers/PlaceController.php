<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class PlaceController extends Controller
{
    public function show ( $id )
    {
        $place = Destination::findOrFail ( $id );
        return view ( 'place-detail', [ 'place' => $place ] );
    }
}
