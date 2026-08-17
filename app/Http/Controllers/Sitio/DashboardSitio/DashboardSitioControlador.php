<?php

namespace App\Http\Controllers\sitio\dashboardsitio;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\SolicitudService;

class DashboardSitioControlador extends Controller
{
    public function inicio(SolicitudService $solicitudService)
    {
        $user = Auth::user();
        $sitioId = session('id_sitio');

        if ($sitioId) {
            $sitio = Sitio::with([
                'perfil.departamento',
                'perfil.municipio',
                'perfil.distrito',
                'perfil.categorias',
                'perfil.reglas',
                'perfil.servicios',
                'imagenes',
                'publicaciones'
            ])->find($sitioId);
        } else {
            $sitio = Sitio::with([
                'perfil.departamento',
                'perfil.municipio',
                'perfil.distrito',
                'perfil.categorias',
                'perfil.reglas',
                'perfil.servicios',
                'imagenes',
                'publicaciones'
            ])->where('id_user', $user->id)->first();
        }

        // Verificación de seguridad
        if (!$sitio || $sitio->id_user !== $user->id) {
            $sitio = Sitio::with([
                'perfil.departamento',
                'perfil.municipio',
                'perfil.distrito',
                'perfil.categorias',
                'perfil.reglas',
                'perfil.servicios',
                'imagenes',
                'publicaciones'
            ])->where('id_user', $user->id)->first();
        }

        if (!$sitio) {
            return redirect()->route('dashboard')->with('error', 'No tienes ningún sitio registrado.');
        }

        $tieneSolicitudPendiente = false;
        if ($sitio && $sitio->perfil) {
            $tieneSolicitudPendiente = $solicitudService->tieneSolicitudPendiente(
                $sitio->id,
                get_class($sitio->perfil),
                $sitio->perfil->id,
                null,
                ['foto_portada']
            );
        }

        return view('admin.dashboard.inicio.inicio', compact('sitio', 'tieneSolicitudPendiente'));
    }
}
