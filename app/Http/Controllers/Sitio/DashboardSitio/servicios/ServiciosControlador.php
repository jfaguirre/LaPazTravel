<?php

namespace App\Http\Controllers\Sitio\DashboardSitio\servicios;

use App\Http\Controllers\Controller;
use App\Models\Servicio;
use App\Models\Sitio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SolicitudService;

class ServiciosControlador extends Controller
{
    public function inicio()
    {

        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión
        if(!$sitio)
        {
            return redirect()->route('dashboard');
        }

        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión       

        $servicios = Servicio::where('estado', 'ACTIVO')->get();
        $selectedServicios = $sitio->perfil->servicios->pluck('id')->toArray();

        return view('admin.dashboard.servicio.inicio', compact('servicios', 'selectedServicios', 'sitio'));
    }


    public function update(Request $request, SolicitudService $solicitudService)
    {        
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión        
        
        if ($sitio && $sitio->perfil && $solicitudService->tieneSolicitudPendiente($sitio->id, get_class($sitio->perfil), $sitio->perfil->id, 'servicios')) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de servicios pendiente de aprobación.');
        }

        $request->validate([
            'servicios' => 'required|array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $solicitudService->registrarRelacion(
            $sitio->perfil,
            'servicios',
            $request->input('servicios', []),
            'Actualización de servicios'
        );

        return redirect()->route('dashboard.sitio.inicio')
            ->with(
                'success',
                'La solicitud de actualización de servicios fue enviada para revisión.'
            );
       
    }
}
