<?php

namespace App\Http\Controllers\Sitio\Sitio;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SitioSlugControlador extends Controller
{
    public function show(string $slug)
    {        
        $sitio = Sitio::where('slug', $slug)->firstOrFail();
        return view('paginas.sitios.show', compact('sitio'));
    }        
}
