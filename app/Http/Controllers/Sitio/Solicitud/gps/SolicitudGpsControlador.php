<?php

namespace App\Http\Controllers\sitio\solicitud\gps;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use Illuminate\Http\Request;

class SolicitudGpsControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $perfil = $sitio->perfil;

        $gps = SitioPerfil::where('id_sitio', session('id_sitio'))
            ->select('latitud', 'longitud')
            ->first();

        return view('admin.solicitud.gps.create', compact('sitio', 'perfil', 'gps'));
    }

    public function store(Request $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'latitud'  => ['required', 'numeric', 'regex:/^-?\d{1,3}\.\d{1,8}$/'],
            'longitud' => ['required', 'numeric', 'regex:/^-?\d{1,3}\.\d{1,8}$/'],
        ]);

        $sitio->perfil->update([
            'latitud'  => $request->latitud,
            'longitud' => $request->longitud,
        ]);

        return redirect()->route('perfil.create')->with('success', 'Coordenadas GPS del sitio guardadas correctamente.');
    }
}

