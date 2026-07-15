<?php

namespace App\Http\Controllers\Categoria;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Categoria;
use App\Models\Sitio;

class CategoriaControlador extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()->route('dashboard')->with('error', 'Primero debes completar los Datos generales de tu sitio.');
        }

        return view('usuarios.categoria.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'icono' => 'required|string|max:100',
            'color' => 'nullable|string|max:20',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('dashboard')->with('error', 'Primero debes completar los Datos generales de tu sitio.');
        }

        // Crear la Categoría
        $categoria = Categoria::create([
            'nombre' => $request->nombre,
            'icono' => $request->icono,
            'color' => $request->color,
            'estado' => $request->estado,
        ]);

        // Asociar la categoría con el perfil del sitio
        $sitio->perfil->categorias()->attach($categoria->id);

        return redirect()->route('dashboard')->with('success', 'Categoría registrada y asociada correctamente.');
    }
}
