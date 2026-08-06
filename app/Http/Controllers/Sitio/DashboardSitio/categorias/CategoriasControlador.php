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
        // $sitio = Sitio::where('id_user', $user->id)->first();
        $sitio = Sitio::find(session('id_sitio')); // Obtener el sitio desde la sesión

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
