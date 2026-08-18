<?php

namespace App\Http\Controllers\Sitio\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardControlador extends Controller
{
    public function dashboard()
    {

        $sitios = Auth::user()->sitios;        
        return view('dashboard', compact('sitios'));
    }
}
