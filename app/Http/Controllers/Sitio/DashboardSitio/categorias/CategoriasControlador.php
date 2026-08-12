<?php

namespace App\Http\Controllers\Sitio\DashboardSitio\categorias;

use App\Http\Controllers\Controller;
use App\Models\Categoria;
use App\Models\Sitio;
use Illuminate\Http\Request;
use App\Services\SolicitudService;

class CategoriasControlador extends Controller
{
     public function inicio()
    {             
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión
        if(!$sitio)
        {
            return redirect()->route('dashboard');
        }

        $categorias = Categoria::where('estado', 'ACTIVO')->get();
        $selectedCategorias = $sitio->perfil->categorias->pluck('id')->toArray();

        return view('admin.dashboard.categoria.inicio', compact('sitio', 'categorias', 'selectedCategorias'));
    }


   public function update(
            Request $request,
            SolicitudService $solicitudService
        )
    {
        $sitio = Sitio::find(session('id_sitio'));

        if ($sitio && $sitio->perfil && $solicitudService->tieneSolicitudPendiente($sitio->id, get_class($sitio->perfil), $sitio->perfil->id, 'categorias')) {
            return redirect()->route('dashboard.sitio.inicio')
                ->with('error', 'Ya tienes una solicitud de actualización de categorías pendiente de aprobación.');
        }
        
        $request->validate([
            'categorias'   => 'nullable|array',
            'categorias.*' => 'exists:categorias,id',
        ]);

        $solicitudService->registrarRelacion(
            $sitio->perfil,
            'categorias',
            $request->input('categorias', []),
            'Actualización de categorías'
        );

        return redirect()->route('dashboard.sitio.inicio')
            ->with(
                'success',
                'La solicitud de actualización de categorías fue enviada para revisión.'
            );
    }
}
