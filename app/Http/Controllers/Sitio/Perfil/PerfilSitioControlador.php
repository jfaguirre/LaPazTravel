<?php

namespace App\Http\Controllers\Sitio\Perfil;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Regla;
use App\Models\Servicio;
use App\Models\Sitio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilSitioControlador extends Controller
{
    
    public function inicio()
    {
        return view('usuarios.inicio');
    }

    public function perfilSitio()
    {
        // Progreso para ir llenando los formularios        
        $user = Auth::user();
        $sitio = Sitio::where('id_user', $user->id)->first();
        $hasSitio = $sitio ? true : false;            
       
        $hasCategoria = (bool) $sitio?->perfil?->categorias()->exists();
        $hasRegla = (bool) $sitio?->perfil?->reglas()->exists();
        $hasServicio = (bool) $sitio?->perfil?->servicios()->exists();                    

        $progreso = 0;
        if ($hasSitio) {
            $progreso += 25;
            if ($hasCategoria) {
                $progreso += 25;
            }
            if ($hasRegla) {
                $progreso += 25;
            }
            if ($hasServicio) {
                $progreso += 25;
            }
        }

        return view('usuarios.perfil.create', compact('hasSitio', 'hasCategoria', 'hasRegla', 'hasServicio', 'progreso', 'sitio'));
    }

    // Funcion para agregar categorias al perfil del sitio.
    public function agregarCategoria()
    {
        $user = Auth::user();
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $categorias = Categoria::where('estado', 'ACTIVO')->get();
        $selectedCategorias = $sitio->perfil->categorias->pluck('id')->toArray();

        return view('usuarios.categoria.agregar', compact('categorias', 'selectedCategorias', 'sitio'));
    }

    public function guardarCategoria(Request $request)
    {
        $user = Auth::user();
        $sitio = Sitio::where('id_user', $user->id)->first();

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
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $reglas = Regla::where('estado', 'ACTIVO')->get();
        $selectedReglas = $sitio->perfil->reglas->pluck('id')->toArray();

        return view('usuarios.regla.agregar', compact('reglas', 'selectedReglas', 'sitio'));
    }

    public function guardarRegla(Request $request)
    {
        $user = Auth::user();
        $sitio = Sitio::where('id_user', $user->id)->first();

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
        $sitio = Sitio::where('id_user', $user->id)->first();

        if (!$sitio) {
            return redirect()->route('perfil.create')->with('error', 'Primero debes completar el Paso 1: Sitio Turístico.');
        }

        $servicios = Servicio::where('estado', 'ACTIVO')->get();
        $selectedServicios = $sitio->perfil->servicios->pluck('id')->toArray();

        return view('usuarios.servicio.agregar', compact('servicios', 'selectedServicios', 'sitio'));
    }

    public function guardarServicio(Request $request)
    {
        $user = Auth::user();
        $sitio = Sitio::where('id_user', $user->id)->first();

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
}
