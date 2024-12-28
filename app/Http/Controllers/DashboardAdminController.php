<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class DashboardAdminController extends Controller
{
    public function index ()
    {
        $destinations  = Destination::all ();
        $active_navbar = 'dashboard_admin';
        return view ( 'admin.dashboard', [ 
            'destinations'  => $destinations,
            'active_navbar' => $active_navbar
        ] );
    }

    public function analytics ()
    {
        return view ( 'dashboard.admin.analytics' );
    }

    public function settings ()
    {
        return view ( 'dashboard.admin.settings' );
    }
}