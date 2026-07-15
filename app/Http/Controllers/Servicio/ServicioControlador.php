<?php

namespace App\Http\Controllers\Servicio;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Servicio;
use App\Models\Sitio;

class ServicioControlador extends Controller
{
    public function create()
    {
        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()->route('dashboard')->with('error', 'Primero debes completar los Datos generales de tu sitio.');
        }

        return view('usuarios.servicio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'servicio' => 'required|string|max:50|unique:servicios,servicio',
            'icono' => 'required|string|max:100',
            'estado' => 'required|in:ACTIVO,INACTIVO',
        ]);

        $user = auth()->user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('dashboard')->with('error', 'Primero debes completar los Datos generales de tu sitio.');
        }

        // Crear el Servicio
        $servicio = Servicio::create([
            'servicio' => $request->servicio,
            'icono' => $request->icono,
            'estado' => $request->estado,
        ]);

        // Asociar el servicio con el perfil del sitio
        $sitio->perfil->servicios()->attach($servicio->id);

        return redirect()->route('dashboard')->with('success', 'Servicio registrado y asociado correctamente.');
    }
}
