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

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50',
            'descripcion_corta' => 'required|string|max:200',
        ]);

        $user = auth()->user();

        // Generar el slug a partir del nombre
        $slug = \Illuminate\Support\Str::slug($request->nombre);

        // Evitar duplicados
        $count = \App\Models\Sitio::where('slug', 'like', "$slug%")->count();
        if ($count > 0) {
            $slug = $slug . '-' . ($count + 1);
        }

        // Crear Sitio
        $sitio = \App\Models\Sitio::create([
            'nombre' => $request->nombre,
            'slug' => $slug,
            'descripcion_corta' => $request->descripcion_corta,
            'id_user' => $user->id,
        ]);

        // Generar identificador único de 10 caracteres
        $identificador = strtoupper(\Illuminate\Support\Str::random(10));
        while (\App\Models\SitioPerfil::where('identificador', $identificador)->exists()) {
            $identificador = strtoupper(\Illuminate\Support\Str::random(10));
        }

        // Crear SitioPerfil
        $perfil = new \App\Models\SitioPerfil();
        $perfil->id_sitio = $sitio->id;
        $perfil->identificador = $identificador;
        $perfil->save();

        return redirect()->route('dashboard')->with('success', 'Ficha del sitio iniciada correctamente.');
    }
}
