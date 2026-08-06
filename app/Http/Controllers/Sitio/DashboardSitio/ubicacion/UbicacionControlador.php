<?php

namespace App\Http\Controllers\sitio\dashboardsitio\ubicacion;

use App\Http\Controllers\Controller;
use App\Models\SitioPerfil;
use App\Services\SolicitudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UbicacionControlador extends Controller
{

    public function index()
    {
        return view('admin.dashboard.ubicacion.inicio');
    }

    public function update(Request $request, SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');

        if ($solicitudService->tieneSolicitudPendiente($idSitio)) {
            return redirect()->route('dashboard.sitio.inicio')->with('error', 'Ya has enviado una solicitud de cambio.');
        }

        $request->validate([
            'departamento' => 'required',
            'municipio' => 'required',
            'distrito' => 'required',
        ]);

        $perfil = SitioPerfil::where('id_sitio', $idSitio)->first();        
        
        $solicitudService->registrarCambio(
            $perfil,
            [
                'id_departamento' => $request->departamento,
                'id_municipio'    => $request->municipio,
                'id_distrito'     => $request->distrito,
            ],            
        );
                       
        return redirect()->route('dashboard.sitio.inicio')->with('success', 'Tu solicitud fue enviada para aprobación.');
    } 
}
