<?php

namespace App\Http\Controllers\sitio\dashboardsitio\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use App\Services\SolicitudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UbicacionControlador extends Controller
{

    public function index()
    {

        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión
        if(!$sitio)
        {
            return redirect()->route('dashboard');
        }

        return view('admin.dashboard.ubicacion.inicio');
    }

    public function update(Request $request, SolicitudService $solicitudService)
    {
       
        $idSitio = session('id_sitio');
        $perfil  = SitioPerfil::where('id_sitio', $idSitio)->first();
    
        if ($perfil && $solicitudService->tieneSolicitudPendiente($idSitio, get_class($perfil), $perfil->id)) {
            return redirect()->route('dashboard.sitio.inicio')->with('error', 'Ya tienes una solicitud pendiente de aprobación para el cambio de ubicación.');
        }

        $request->validate([
            'departamento' => 'required',
            'municipio'    => 'required',
            'distrito'     => 'required',
        ]);

        $solicitudService->registrarCambio(
            $perfil,
            [
                'id_departamento' => $request->departamento,
                'id_municipio'    => $request->municipio,
                'id_distrito'     => $request->distrito,
            ],
            'Actualización de Ubicación (Departamento, Municipio, Distrito)'
        );
                       
        return redirect()->route('dashboard.sitio.inicio')->with('success', 'Tu solicitud fue enviada para aprobación.');
    } 
}
