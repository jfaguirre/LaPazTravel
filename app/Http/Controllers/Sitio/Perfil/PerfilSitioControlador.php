<?php

namespace App\Http\Controllers\Sitio\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\SitioPerfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class PerfilSitioControlador extends Controller
{

    public function perfil_session(Request $request)
    {
        $request->validate([
            'id_sitio' => 'required|exists:sitios,id',
        ]);

        // Guardar el id del sitio en la sesión
        session(['id_sitio' => $request->input('id_sitio')]);

        $sitio = Sitio::find($request->input('id_sitio'));

            if($sitio->estado === 'APROBADO')
            {
                return redirect()->route('dashboard.sitio.inicio');                
            }

        return redirect()->route('perfil.create');
    }


    public function perfilSitio()
    {                
        // Obtener el sitio desde la sesión
        $sitio = Sitio::find(session('id_sitio'));
        $hasSitio = $sitio ? true : false;
        
        $hasCategoria = (bool) $sitio?->perfil?->categorias()->exists();
        $hasRegla = (bool) $sitio?->perfil?->reglas()->exists();
        $hasServicio = (bool) $sitio?->perfil?->servicios()->exists();
        $hasHorario = (bool) (!empty($sitio?->perfil?->horarios));
        $hasPrecio = (bool) $sitio?->perfil?->precios()->exists();
        $hasGps = (bool) ($sitio?->perfil?->latitud !== null && $sitio?->perfil?->longitud !== null);
        $hasPortada = (bool) (!empty($sitio?->perfil?->foto_portada));
        $hasFotoPerfil = (bool) (!empty($sitio?->perfil?->foto_perfil));
        $hasUbicacion = SitioPerfil::where('id_sitio', session('id_sitio'))
            ->whereNotNull('id_departamento')
            ->whereNotNull('id_municipio')
            ->whereNotNull('id_distrito')
            ->exists();

        $completedSteps = 0;
        if ($hasSitio) $completedSteps++;
        if ($hasUbicacion) $completedSteps++;
        if ($hasCategoria) $completedSteps++;
        if ($hasRegla) $completedSteps++;
        if ($hasServicio) $completedSteps++;
        if ($hasHorario) $completedSteps++;
        if ($hasPrecio) $completedSteps++;
        if ($hasGps) $completedSteps++;
        if ($hasPortada) $completedSteps++;
        if ($hasFotoPerfil) $completedSteps++;

        $progreso = (int) round(($completedSteps / 10) * 100);

        return view('admin.perfil.create',
        compact(
            'hasSitio',
            'hasUbicacion',
            'hasCategoria',
            'hasRegla',            
            'hasServicio',
            'hasHorario',
            'hasPrecio',
            'hasGps',
            'hasPortada',
            'hasFotoPerfil',
            'progreso',
            'sitio'));
    }

    public function ubicacion_sitio()

    {
        return view('admin.ubicacion.agregar');
    }

    public function guardar_ubicacion(Request $request)
    {

         $request->validate([
            'departamento' => 'required',
            'municipio' => 'required',
            'distrito' => 'required',
        ]);

        $perfil = SitioPerfil::where('id_sitio', session('id_sitio'))->first();

        $perfil->update([
            'id_departamento' => $request->departamento,
            'id_municipio' => $request->municipio,
            'id_distrito' => $request->distrito,
        ]);

        return redirect()->route('perfil.create')->with('success', 'Ubicación guardada correctamente.');
    }
}
