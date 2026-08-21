<?php

namespace App\Http\Controllers\sitio\solicitud\categorias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SolicitudCategoriaControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $categorias = Categoria::where('estado', 'ACTIVO')->get();
        $selectedCategorias = $sitio->perfil ? $sitio->perfil->categorias->pluck('id')->toArray() : [];

        return view('admin.solicitud.categorias.create', compact('categorias', 'selectedCategorias', 'sitio'));
    }

    public function store(Request $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'categorias'   => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
        ]);

        if ($sitio->perfil) {
            $sitio->perfil->categorias()->sync($request->input('categorias', []));
        }

        return redirect()->route('perfil.create')->with('success', 'Categorías del perfil actualizadas correctamente.');
    }
}

