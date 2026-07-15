<?php

namespace App\Http\Controllers\Regla;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Regla;
use App\Models\Sitio;

class ReglaControlador extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()->route('dashboard')->with('error', 'Primero debes completar los Datos generales de tu sitio.');
        }

        return view('usuarios.regla.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'regla' => 'required|string|max:20|unique:reglas,regla',
            'icono' => 'required|string|max:100',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('dashboard')->with('error', 'Primero debes completar los Datos generales de tu sitio.');
        }

        // Crear la Regla
        $regla = Regla::create([
            'regla' => $request->regla,
            'icono' => $request->icono,
            'estado' => $request->estado,
        ]);

        // Asociar la regla con el perfil del sitio
        $sitio->perfil->reglas()->attach($regla->id);

        return redirect()->route('dashboard')->with('success', 'Regla registrada y asociada correctamente.');
    }
}
