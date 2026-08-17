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

        if ($solicitudService->tieneSolicitudPendiente($sitio->id, get_class($sitio), $sitio->id, null, ['nombre', 'slug', 'descripcion_corta'])) {
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

        $sitioArray = $sitio->toArray();
        $antesSitio = [];
        foreach (array_keys($datosSitio) as $key) {
            if (array_key_exists($key, $sitioArray)) {
                $antesSitio[$key] = $sitioArray[$key];
            }
        }

        // Operación 1: Cambios en el modelo Sitio
        $solicitudService->agregarOperacion(
            $solicitud,
            get_class($sitio),
            $sitio->id,
            'UPDATE',
            [
                'antes'   => $antesSitio,
                'despues' => $datosSitio,
                'campos'  => array_keys($datosSitio),
            ],
            'Actualización de datos generales del sitio'
        );

        // Operación 2: Cambios en el modelo SitioPerfil
        if ($perfil) {
            $perfilArray = $perfil->toArray();
            $antesPerfil = [];
            foreach (array_keys($datosPerfil) as $key) {
                if (array_key_exists($key, $perfilArray)) {
                    $antesPerfil[$key] = $perfilArray[$key];
                }
            }

            $solicitudService->agregarOperacion(
                $solicitud,
                get_class($perfil),
                $perfil->id,
                'UPDATE',
                [
                    'antes'   => $antesPerfil,
                    'despues' => $datosPerfil,
                    'campos'  => array_keys($datosPerfil),
                ],
                'Actualización de datos de contacto del sitio'
            );
        }

        return redirect()->route('dashboard.sitio.inicio')
            ->with('success', 'Tu solicitud de actualización de información fue enviada para aprobación.');
    }
}
