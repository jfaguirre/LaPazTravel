<?php

namespace App\Http\Controllers\Sitio\DashboardSitio\reglas;

use App\Http\Controllers\Controller;
use App\Models\Regla;
use App\Models\Sitio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SolicitudService;

class ReglasControlador extends Controller
{
    // Funcion para agregar reglas al perfil del sitio.
    public function inicio()
    {        
        
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión
        if(!$sitio)
        {
            return redirect()->route('dashboard');
        }

        $reglas = Regla::where('estado', 'ACTIVO')->get();
        $selectedReglas = $sitio->perfil->reglas->pluck('id')->toArray();
                
        return view('admin.dashboard.regla.inicio', compact('reglas', 'selectedReglas', 'sitio'));
    }


    public function update(Request $request, SolicitudService $solicitudService)
    {
        $user = Auth::user();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

        if ($sitio && $sitio->perfil && $solicitudService->tieneSolicitudPendiente($sitio->id, get_class($sitio->perfil), $sitio->perfil->id, 'categorias')) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de reglas pendiente de aprobación.');
        }

        $request->validate([
            'reglas' => 'required|array',
            'reglas.*' => 'exists:reglas,id',              
        ]);

         $solicitudService->registrarRelacion(
            $sitio->perfil,
            'reglas',
            $request->input('reglas', []),
            'Actualización de reglas y normas'
        );

        return redirect()->route('dashboard.sitio.inicio')
            ->with(
                'success',
                'La solicitud de actualización de reglas fue enviada para revisión.'
            );

        // $sitio->perfil->reglas()->sync($request->input('reglas', []));

        // return redirect()->route('perfil.create')->with('success', 'Reglas del perfil actualizadas correctamente.');
    }
}
