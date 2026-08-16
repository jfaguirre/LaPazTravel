<?php

namespace App\Http\Controllers\Sitio\DashboardSitio\informacion;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use App\Services\SolicitudService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InformacionControlador extends Controller
{
    public function inicio()
    {

        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión
                
        if(!$sitio)
        {
            return redirect()->route('dashboard');
        }        

        return view('admin.dashboard.informacion.inicio', compact('sitio'));
    }

    public function update(Request $request, SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio = Sitio::find($idSitio);

        if (!$sitio) {
            return redirect()->route('dashboard');
        }

        $perfil = $sitio->perfil;

        if ($solicitudService->tieneSolicitudPendiente($sitio->id, get_class($sitio), $sitio->id)) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de información general pendiente de aprobación.');
        }

        $request->validate([
            'nombre'            => 'required|string|max:50',
            'slug'              => 'required|string|max:50',
            'descripcion_corta' => 'required|string|max:200',
            'telefono'          => 'nullable|string|max:9',
            'correo'            => 'nullable|email|max:100',
            'direccion'         => 'nullable|string|max:150',
        ]);

        $datosSitio = [
            'nombre'            => $request->input('nombre'),
            'slug'              => $request->input('slug'),
            'descripcion_corta' => $request->input('descripcion_corta'),
        ];

        $datosPerfil = [
            'telefono'             => $request->input('telefono'),
            'correo_institucional' => $request->input('correo'),
            'direccion'            => $request->input('direccion'),
        ];

        // Crear una única solicitud contenedora
        $solicitud = $solicitudService->crearSolicitud(
            Auth::id(),
            $sitio->id,
            'Actualización de información general y de contacto'
        );

        // Operación 1: Cambios en el modelo Sitio
        $solicitudService->agregarOperacion(
            $solicitud,
            get_class($sitio),
            $sitio->id,
            'UPDATE',
            [
                'antes'   => $sitio->toArray(),
                'despues' => array_merge($sitio->toArray(), $datosSitio),
            ],
            'Actualización de datos generales del sitio'
        );

        // Operación 2: Cambios en el modelo SitioPerfil
        if ($perfil) {
            $solicitudService->agregarOperacion(
                $solicitud,
                get_class($perfil),
                $perfil->id,
                'UPDATE',
                [
                    'antes'   => $perfil->toArray(),
                    'despues' => array_merge($perfil->toArray(), $datosPerfil),
                ],
                'Actualización de datos de contacto del sitio'
            );
        }

        return redirect()->route('dashboard.sitio.inicio')
            ->with('success', 'Tu solicitud de actualización de información fue enviada para aprobación.');
    }
}
