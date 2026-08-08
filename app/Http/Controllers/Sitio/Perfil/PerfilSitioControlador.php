<?php

namespace App\Http\Controllers\Sitio\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Regla;
use App\Models\Servicio;
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
        $hasUbicacion = SitioPerfil::where('id_sitio', session('id_sitio'))
            ->whereNotNull('id_departamento')
            ->whereNotNull('id_municipio')
            ->whereNotNull('id_distrito')
            ->exists();

        $progreso = 0;
        if ($hasSitio) {
            if ($hasUbicacion) {
                $progreso += 20;
            }
            $progreso += 20;
            if ($hasCategoria) {
                $progreso += 20;
            }
            if ($hasRegla) {
                $progreso += 20;
            }
            if ($hasServicio) {
                $progreso += 20;
            }
        }

        return view('admin.perfil.create',
        compact(
            'hasSitio',
            'hasUbicacion',
            'hasCategoria',
            'hasRegla',            
            'hasServicio',
            'progreso',
            'sitio'));
    }

    // Funcion para agregar categorias al perfil del sitio.
    public function agregarCategoria()
    {
        $user = Auth::user();
        // $sitio = Sitio::where('id_user', $user->id)->first();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $categorias = Categoria::where('estado', 'ACTIVO')->get();
        $selectedCategorias = $sitio->perfil->categorias->pluck('id')->toArray();

        return view('admin.categoria.agregar', compact('categorias', 'selectedCategorias', 'sitio'));
    }

    public function guardarCategoria(Request $request)
    {                
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'categorias' => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
        ]);

        $sitio->perfil->categorias()->sync($request->input('categorias', []));

        return redirect()->route('perfil.create')->with('success', 'Categorías del perfil actualizadas correctamente.');
    }

    // Funcion para agregar reglas al perfil del sitio.
    public function agregarRegla()
    {
        $user = Auth::user();
        // $sitio = Sitio::where('id_user', $user->id)->first();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $reglas = Regla::where('estado', 'ACTIVO')->get();
        $selectedReglas = $sitio->perfil->reglas->pluck('id')->toArray();

        return view('admin.regla.agregar', compact('reglas', 'selectedReglas', 'sitio'));
    }


    public function guardarRegla(Request $request)
    {
        $user = Auth::user();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión
        // $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'reglas' => 'nullable|array',
            'reglas.*' => 'exists:reglas,id',
        ]);

        $sitio->perfil->reglas()->sync($request->input('reglas', []));

        return redirect()->route('perfil.create')->with('success', 'Reglas del perfil actualizadas correctamente.');
    }


    // Funcion para agregar servicios al perfil del sitio.
    public function agregarServicio()
    {
        $user = Auth::user();
        // $sitio = Sitio::where('id_user', $user->id)->first();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $servicios = Servicio::where('estado', 'ACTIVO')->get();
        $selectedServicios = $sitio->perfil->servicios->pluck('id')->toArray();

        return view('admin.servicio.agregar', compact('servicios', 'selectedServicios', 'sitio'));
    }


    public function guardarServicio(Request $request)
    {
        $user = Auth::user();
        // $sitio = Sitio::where('id_user', $user->id)->first();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $request->validate([
            'servicios' => 'nullable|array',
            'servicios.*' => 'exists:servicios,id',
        ]);

        $sitio->perfil->servicios()->sync($request->input('servicios', []));

        return redirect()->route('perfil.create')->with('success', 'Servicios del perfil actualizados correctamente.');
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
