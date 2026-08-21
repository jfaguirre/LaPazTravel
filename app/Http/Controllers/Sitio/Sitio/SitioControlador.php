<?php

namespace App\Http\Controllers\Sitio\Sitio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SitioControlador extends Controller
{
    public function create()
    {
        session()->forget('id_sitio');
        return redirect()->route('informacion.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('informacion.create');
    }

    public function edit()
    {
        return redirect()->route('informacion.create');
    }

    public function update(Request $request)
    {
        return redirect()->route('informacion.create');
    }
}
