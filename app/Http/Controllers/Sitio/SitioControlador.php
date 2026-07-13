<?php

namespace App\Http\Controllers\Sitio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SitioControlador extends Controller
{
    public function create()
    {
        return view('usuarios.sitio.create');
    }
}
