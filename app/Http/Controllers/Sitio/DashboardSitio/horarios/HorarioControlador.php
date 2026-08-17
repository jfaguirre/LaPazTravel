<?php

namespace App\Http\Controllers\sitio\dashboardsitio\horarios;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use App\Services\SolicitudService;
use Illuminate\Http\Request;

class HorarioControlador extends Controller
{
    public function inicio(SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio   = Sitio::find($idSitio);

        if (!$sitio) {
            return redirect()->route('dashboard');
        }

        $perfil   = $sitio->perfil;
        $horarios = [];

        if ($perfil && $perfil->horarios) {
            if (is_array($perfil->horarios)) {
                $horarios = $perfil->horarios;
            } else {
                $decoded = json_decode($perfil->horarios, true);
                $horarios = is_array($decoded) ? $decoded : [];
            }
        }

        $tieneSolicitudPendiente = false;
        if ($perfil) {
            $tieneSolicitudPendiente = $solicitudService->tieneSolicitudPendiente(
                $sitio->id,
                get_class($perfil),
                $perfil->id,
                null,
                ['horarios']
            );
        }

        return view('admin.dashboard.horario.inicio', compact('sitio', 'perfil', 'horarios', 'tieneSolicitudPendiente'));
    }

    public function update(Request $request, SolicitudService $solicitudService)
    {
        $idSitio = session('id_sitio');
        $sitio   = Sitio::find($idSitio);

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('dashboard');
        }

        $perfil = $sitio->perfil;

        if ($solicitudService->tieneSolicitudPendiente($sitio->id, get_class($perfil), $perfil->id, null, ['horarios'])) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de horarios pendiente de aprobación.');
        }

        $request->validate([
            'horarios'                       => 'required|array',
            'horarios.*.estado'              => 'required|string|in:abierto,cerrado,24h,personalizado',
            'horarios.*.apertura'            => 'nullable|string',
            'horarios.*.cierre'              => 'nullable|string',
            'horarios.*.personalizado'       => 'nullable|string|max:100',
        ]);

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        $horariosFinales = [];

        foreach ($diasSemana as $dia) {
            $dataDia = $request->input("horarios.$dia", []);
            $estado  = $dataDia['estado'] ?? 'cerrado';

            if ($estado === 'abierto') {
                $apertura = !empty($dataDia['apertura']) ? trim($dataDia['apertura']) : '08:00';
                $cierre   = !empty($dataDia['cierre'])   ? trim($dataDia['cierre'])   : '17:00';
                $horariosFinales[$dia] = "{$apertura} - {$cierre}";
            } elseif ($estado === '24h') {
                $horariosFinales[$dia] = '24 Horas';
            } elseif ($estado === 'personalizado') {
                $texto = !empty($dataDia['personalizado']) ? trim($dataDia['personalizado']) : 'Horario especial';
                $horariosFinales[$dia] = $texto;
            } else {
                $horariosFinales[$dia] = 'Cerrado';
            }
        }

        $solicitudService->registrarCambio(
            $perfil,
            [
                'horarios' => json_encode($horariosFinales, JSON_UNESCAPED_UNICODE)
            ],
            'Actualización de horarios de atención del sitio.'
        );

        return redirect()->route('dashboard.sitio.inicio')
            ->with('success', 'Tu solicitud de actualización de horarios fue enviada para aprobación.');
    }
}

