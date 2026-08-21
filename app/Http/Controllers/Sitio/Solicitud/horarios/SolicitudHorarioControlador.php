<?php

namespace App\Http\Controllers\sitio\solicitud\horarios;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SolicitudHorarioControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
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

        return view('admin.solicitud.horarios.create', compact('sitio', 'perfil', 'horarios'));
    }

    public function store(Request $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio || !$sitio->perfil) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'horarios'                 => 'required|array',
            'horarios.*.estado'        => 'required|string|in:abierto,cerrado,24h,personalizado',
            'horarios.*.apertura'      => 'nullable|string',
            'horarios.*.cierre'        => 'nullable|string',
            'horarios.*.personalizado' => 'nullable|string|max:100',
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

        $sitio->perfil->update([
            'horarios' => json_encode($horariosFinales, JSON_UNESCAPED_UNICODE)
        ]);

        return redirect()->route('perfil.create')->with('success', 'Horarios del sitio guardados correctamente.');
    }
}

