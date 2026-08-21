<?php

namespace App\Http\Controllers\sitio\solicitud\reglas;

use App\Http\Controllers\Controller;
use App\Models\Regla;
use App\Models\Sitio;
use Illuminate\Http\Request;

class SolicituReglaControlador extends Controller
{
    public function create()
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $reglas = Regla::where('estado', 'ACTIVO')->get();

        $selectedReglasMap = [];
        if ($sitio->perfil) {
            foreach ($sitio->perfil->reglas as $r) {
                $selectedReglasMap[$r->id] = (bool) $r->pivot->permitido;
            }
        }
        $selectedReglas = array_keys($selectedReglasMap);

        return view('admin.solicitud.reglas.create', compact('reglas', 'selectedReglas', 'selectedReglasMap', 'sitio'));
    }

    public function store(Request $request)
    {
        $sitio = Sitio::find(session('id_sitio'));

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'reglas'    => 'nullable|array',
            'reglas.*'  => 'exists:reglas,id',
            'permitido' => 'nullable|array',
        ]);

        if ($sitio->perfil) {
            $selectedIds = $request->input('reglas', []);
            $permitidosMap = $request->input('permitido', []);

            $syncData = [];
            foreach ($selectedIds as $reglaId) {
                $isPermitido = isset($permitidosMap[$reglaId]) && (int)$permitidosMap[$reglaId] === 1;
                $syncData[$reglaId] = [
                    'permitido' => $isPermitido,
                    'color'     => $isPermitido ? '#00b344' : '#e53e3e',
                ];
            }

            $sitio->perfil->reglas()->sync($syncData);
        }

        return redirect()->route('perfil.create')->with('success', 'Reglas del perfil actualizadas correctamente.');
    }
}

