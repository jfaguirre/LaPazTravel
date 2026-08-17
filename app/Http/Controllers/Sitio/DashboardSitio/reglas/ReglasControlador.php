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
        
        $selectedReglasMap = [];
        if ($sitio->perfil) {
            foreach ($sitio->perfil->reglas as $r) {
                $selectedReglasMap[$r->id] = (bool) $r->pivot->permitido;
            }
        }
        $selectedReglas = array_keys($selectedReglasMap);

        return view('admin.dashboard.regla.inicio', compact('reglas', 'selectedReglas', 'selectedReglasMap', 'sitio'));
    }


    public function update(Request $request, SolicitudService $solicitudService)
    {
        $user = Auth::user();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

        if ($sitio && $sitio->perfil && $solicitudService->tieneSolicitudPendiente($sitio->id, get_class($sitio->perfil), $sitio->perfil->id, 'reglas')) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de reglas pendiente de aprobación.');
        }

        $request->validate([
            'reglas' => 'nullable|array',
            'reglas.*' => 'exists:reglas,id',
            'permitido' => 'nullable|array',
        ]);

        $selectedIds = $request->input('reglas', []);
        $permitidosMap = $request->input('permitido', []);

        $syncData = [];
        foreach ($selectedIds as $reglaId) {
            $isPermitido = isset($permitidosMap[$reglaId]) && (int)$permitidosMap[$reglaId] === 1;
            $syncData[$reglaId] = [
                'permitido' => $isPermitido,
                'color'     => $isPermitido ? '#00b344' : '#e53e3e',
            ];
        }

        $solicitudService->registrarRelacion(
            $sitio->perfil,
            'reglas',
            $syncData,
            'Actualización de reglas y normas'
        );

        return redirect()->route('dashboard.sitio.inicio')
            ->with(
                'success',
                'La solicitud de actualización de reglas fue enviada para revisión.'
            );        
    }
}
