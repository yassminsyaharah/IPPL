<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function subscribe ( Request $request )
    {
        return redirect ()->route ( 'onboarding' )->with ( 'success', 'You have successfully subscribed to our newsletter.' );
    }
}
