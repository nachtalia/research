<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Return the dashboard view with Inertia
        return Inertia::render('Dashboard');
    }
}
