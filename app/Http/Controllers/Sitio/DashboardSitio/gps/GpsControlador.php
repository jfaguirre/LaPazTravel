<?php

namespace App\Http\Controllers\sitio\dashboardsitio\gps;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use App\Services\SolicitudService;
use Illuminate\Http\Request;

class GpsControlador extends Controller
{
    public function inicio()
    {

        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión
                         
        if(!$sitio)
        {
            return redirect()->route('dashboard');
        } 

        $gps = SitioPerfil::where('id', $sitio->id)
            ->select('latitud', 'longitud')
            ->first();
        
        return view('admin.dashboard.gps.inicio', compact('sitio', 'gps'));

    }

    public function update(Request $request, SolicitudService $solicitudService)
    {
    
        $idSitio = session('id_sitio');
        $perfil  = SitioPerfil::where('id_sitio', $idSitio)->first();
    
        if ($perfil && $solicitudService->tieneSolicitudPendiente($idSitio, get_class($perfil), $perfil->id, null, ['latitud', 'longitud'])) {
            return redirect()->route('dashboard.sitio.inicio')->with('error', 'Ya tienes una solicitud pendiente de aprobación para el cambio de coordenadas geográficas en el mapa.');
        }
        
        $request->validate([
            'latitud'  => ['required', 'numeric', 'regex:/^-?\d{1,2}\.\d{1,8}$/'],
            'longitud' => ['required', 'numeric', 'regex:/^-?\d{1,3}\.\d{1,8}$/'],
        ]);

        $solicitudService->registrarCambio(
            $perfil,
            [
                'latitud' => $request->latitud,
                'longitud'    => $request->longitud,                
            ],
            'Actualización de coordenadas geográficas del sitio en el mapa.'
        );
                       
        return redirect()->route('dashboard.sitio.inicio')->with('success', 'Tu solicitud fue enviada para aprobación.');

    }
}
