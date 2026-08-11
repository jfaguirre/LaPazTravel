<?php

namespace App\Http\Controllers\Super\Solicitud;

use App\Http\Controllers\Controller;
use App\Models\Solicitud;
use App\Services\SolicitudService;
use Illuminate\Http\Request;

class SolicitudControlador extends Controller
{
    /**
     * Listado general de solicitudes para el Super Admin.
     */
    public function index(Request $request)
    {
        $estado = $request->query('estado');

        $query = Solicitud::with(['sitio', 'usuario', 'operaciones']);        

        if ($estado && in_array(strtoupper($estado), ['PENDIENTE', 'APROBADA', 'RECHAZADA', 'CANCELADA'])) {
            $query->where('estado', strtoupper($estado));
        }

        $solicitudes = $query->latest()->paginate(12)->withQueryString();

        // Conteo general por estados para los filtros visuales
        $conteos = [
            'todos'     => Solicitud::count(),
            'pendiente' => Solicitud::where('estado', 'PENDIENTE')->count(),
            'aprobada'  => Solicitud::where('estado', 'APROBADA')->count(),
            'rechazada' => Solicitud::where('estado', 'RECHAZADA')->count(),
        ];

        return view('super.solicitud.index', compact('solicitudes', 'estado', 'conteos'));
    }

    /**
     * Ver el detalle de una solicitud específica.
     */
    public function show($id)
    {
        $solicitud = Solicitud::with(['sitio', 'usuario', 'operaciones', 'revisor'])
            ->findOrFail($id);

        return view('super.solicitud.show', compact('solicitud'));
    }

    /**
     * Aprobar la solicitud y aplicar sus cambios.
     */
    public function aprobar($id, SolicitudService $solicitudService)
    {
        $solicitud = Solicitud::findOrFail($id);

        if ($solicitud->estado !== 'PENDIENTE') {
            return redirect()->route('super.solicitudes.show', $id)
                ->with('error', 'Esta solicitud ya ha sido procesada previamente.');
        }

        try {
            $solicitudService->aprobarSolicitud($solicitud);

            return redirect()->route('super.solicitudes.show', $id)
                ->with('success', '¡Solicitud APROBADA con éxito! Los cambios fueron aplicados al sitio.');
        } catch (\Exception $e) {
            return redirect()->route('super.solicitudes.show', $id)
                ->with('error', 'Ocurrió un error al procesar la aprobación: ' . $e->getMessage());
        }
    }

    /**
     * Rechazar la solicitud.
     */
    public function rechazar(Request $request, $id, SolicitudService $solicitudService)
    {
        $solicitud = Solicitud::findOrFail($id);

        if ($solicitud->estado !== 'PENDIENTE') {
            return redirect()->route('super.solicitudes.show', $id)
                ->with('error', 'Esta solicitud ya ha sido procesada previamente.');
        }

        $request->validate([
            'comentario_admin' => 'nullable|string|max:1000',
        ]);

        $solicitudService->rechazarSolicitud($solicitud, $request->input('comentario_admin'));

        return redirect()->route('super.solicitudes.show', $id)
            ->with('success', 'La solicitud ha sido RECHAZADA.');
    }
}
