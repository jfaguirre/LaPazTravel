<?php

namespace App\Http\Controllers\sitio\dashboardsitio\redes;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use App\Services\SolicitudService;
use Illuminate\Http\Request;

class RedesControlador extends Controller
{
    public function inicio(SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio = Sitio::find($idSitio);

        if (!$sitio) {
            return redirect()->route('dashboard');
        }

        $perfil = $sitio->perfil;
        $tieneSolicitudPendiente = false;

        if ($perfil) {
            $tieneSolicitudPendiente = $solicitudService->tieneSolicitudPendiente(
                $sitio->id,
                get_class($perfil),
                $perfil->id,
                null,
                ['facebook', 'instagram', 'tiktok', 'youtube', 'sitio_web']
            );
        }

        return view('admin.dashboard.redes.inicio', compact('sitio', 'perfil', 'tieneSolicitudPendiente'));
    }

    public function update(Request $request, SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio = Sitio::find($idSitio);

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('dashboard');
        }

        $perfil = $sitio->perfil;

        if ($solicitudService->tieneSolicitudPendiente($sitio->id, get_class($perfil), $perfil->id, null, ['facebook', 'instagram', 'tiktok', 'youtube', 'sitio_web'])) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de redes sociales pendiente de aprobación.');
        }

        $request->validate([
            'facebook'  => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'tiktok'    => 'nullable|url|max:255',
            'youtube'   => 'nullable|url|max:255',
            'sitio_web' => 'nullable|url|max:255',
        ], [
            'facebook.url'  => 'La URL de Facebook debe ser un enlace válido (ej. https://facebook.com/pagina).',
            'instagram.url' => 'La URL de Instagram debe ser un enlace válido (ej. https://instagram.com/cuenta).',
            'tiktok.url'    => 'La URL de TikTok debe ser un enlace válido (ej. https://tiktok.com/@usuario).',
            'youtube.url'   => 'La URL de YouTube debe ser un enlace válido (ej. https://youtube.com/@canal).',
            'sitio_web.url' => 'La URL del sitio web debe ser un enlace válido (ej. https://misitioweb.com).',
            'facebook.max'  => 'La URL de Facebook no debe superar los 255 caracteres.',
            'instagram.max' => 'La URL de Instagram no debe superar los 255 caracteres.',
            'tiktok.max'    => 'La URL de TikTok no debe superar los 255 caracteres.',
            'youtube.max'   => 'La URL de YouTube no debe superar los 255 caracteres.',
            'sitio_web.max' => 'La URL del sitio web no debe superar los 255 caracteres.',
        ]);

        $datosSociales = [
            'facebook'  => $request->input('facebook') ? trim($request->input('facebook')) : null,
            'instagram' => $request->input('instagram') ? trim($request->input('instagram')) : null,
            'tiktok'    => $request->input('tiktok') ? trim($request->input('tiktok')) : null,
            'youtube'   => $request->input('youtube') ? trim($request->input('youtube')) : null,
            'sitio_web' => $request->input('sitio_web') ? trim($request->input('sitio_web')) : null,
        ];

        $solicitudService->registrarCambio(
            $perfil,
            $datosSociales,
            'Actualización de redes sociales y sitio web'
        );

        return redirect()->route('dashboard.sitio.inicio')
            ->with('success', 'Tu solicitud de actualización de redes sociales fue enviada para aprobación.');
    }
}
