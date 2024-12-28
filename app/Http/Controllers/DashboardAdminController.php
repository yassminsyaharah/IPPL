<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destination;

class DashboardAdminController extends Controller
{
    public function index()
    {
        $destinations = Destination::all();
        return view('admin.dashboard', compact('destinations'));
    }

    public function analytics()
    {
        return view('dashboard.admin.analytics');
    }

    public function settings()
    {
        return view('dashboard.admin.settings');
    }
}