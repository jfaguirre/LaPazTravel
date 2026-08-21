<?php

namespace App\Http\Controllers\sitio\solicitud\servicios;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SolicitudServicioControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $servicios = Servicio::where('estado', 'ACTIVO')->get();
        $selectedServicios = $sitio->perfil ? $sitio->perfil->servicios->pluck('id')->toArray() : [];

        return view('admin.solicitud.servicios.create', compact('servicios', 'selectedServicios', 'sitio'));
    }

    public function store(Request $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'servicios'   => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        if ($sitio->perfil) {
            $sitio->perfil->servicios()->sync($request->input('servicios', []));
        }

        return redirect()->route('perfil.create')->with('success', 'Servicios del perfil actualizados correctamente.');
    }
}

