<?php

namespace App\Http\Middleware;

use App\Models\Sitio;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccesoSitio
{    
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        
        $sitioId = session('id_sitio');
        if ($sitioId) {
            $sitio = Sitio::find($sitioId);
        } else {
            $sitio = Sitio::where('id_user', $user->id)->first();
        }

        // Verificación de seguridad: Asegurarse de que el sitio cargado pertenezca al usuario autenticado
        if ($sitio && $sitio->id_user !== $user->id) {
            $sitio = Sitio::where('id_user', $user->id)->first();
        }

        $perfil = $sitio?->perfil;

        // Si el sitio no existe
        if ($sitio === null) {
            if ($request->routeIs('sitio.create') || $request->routeIs('sitio.store') || $request->routeIs('informacion.create') || $request->routeIs('informacion.store')) {
                return $next($request);
            }
            return redirect()->route('dashboard');
        }

        // Rutas
        if ($sitio->estado === 'PENDIENTE') {
            if ($request->routeIs('sitio.edit') || 
                $request->routeIs('sitio.update') || 
                $request->routeIs('informacion.create') ||
                $request->routeIs('informacion.store') ||
                $request->routeIs('perfil.ubicacion.agregar') || 
                $request->routeIs('perfil.ubicacion.store') || 
                $request->routeIs('categoria.create') || 
                $request->routeIs('categoria.store') || 
                $request->routeIs('regla.create') || 
                $request->routeIs('regla.store') || 
                $request->routeIs('servicio.create') || 
                $request->routeIs('servicio.store') ||
                $request->routeIs('horario.create') ||
                $request->routeIs('horario.store') ||
                $request->routeIs('precio.create') ||
                $request->routeIs('precio.store') ||
                $request->routeIs('gps.create') ||
                $request->routeIs('gps.store') ||
                $request->routeIs('portada.create') ||
                $request->routeIs('portada.store') ||
                $request->routeIs('fotoperfil.create') ||
                $request->routeIs('fotoperfil.store')) {
                
                return redirect()->route('perfil.create')->with('error', 'No puedes editar la información de tu sitio mientras la solicitud está pendiente de aprobación.');
            }
        }

        $hasCategoria = (bool) $perfil?->categorias()->exists();
        $hasRegla = (bool) $perfil?->reglas()->exists();
        $hasServicio = (bool) $perfil?->servicios()->exists();
        $hasHorario = (bool) (!empty($perfil?->horarios));
        $hasPrecio = (bool) $perfil?->precios()->exists();
        $hasGps = (bool) ($perfil?->latitud !== null && $perfil?->longitud !== null);
        $hasPortada = (bool) (!empty($perfil?->foto_portada));
        $hasFotoPerfil = (bool) (!empty($perfil?->foto_perfil));

        // Crear nuevo sitio
        if ($request->routeIs('sitio.create') || $request->routeIs('sitio.store') || $request->routeIs('informacion.create') || $request->routeIs('informacion.store')) {
            return $next($request);
        }

        // Mientras sea BORRADOR
        if ($sitio->estado === 'BORRADOR') {
            if ($request->routeIs('sitio.edit') || $request->routeIs('sitio.update') ||
                $request->routeIs('informacion.create') || $request->routeIs('informacion.store') ||
                $request->routeIs('perfil.ubicacion.agregar') || $request->routeIs('perfil.ubicacion.store') ||
                $request->routeIs('categoria.create') || $request->routeIs('categoria.store') ||
                $request->routeIs('regla.create') || $request->routeIs('regla.store') ||
                $request->routeIs('servicio.create') || $request->routeIs('servicio.store') ||
                $request->routeIs('horario.create') || $request->routeIs('horario.store') ||
                $request->routeIs('precio.create') || $request->routeIs('precio.store') ||
                $request->routeIs('gps.create') || $request->routeIs('gps.store') ||
                $request->routeIs('portada.create') || $request->routeIs('portada.store') ||
                $request->routeIs('fotoperfil.create') || $request->routeIs('fotoperfil.store')) {
                return $next($request);
            }
        }




        // Rutas en curso
        if (!$perfil || !$hasCategoria || !$hasRegla || !$hasServicio || !$hasHorario || !$hasPrecio || !$hasGps || !$hasPortada || !$hasFotoPerfil) {
            return redirect()->route('perfil.create');
        }






        if ($sitio->estado === 'BORRADOR') {
            return redirect()->route('perfil.create');
        }

        if ($sitio->estado === 'APROBADO') {
            return redirect()->route('dashboard');
        }
      
        return $next($request);
    }
}
