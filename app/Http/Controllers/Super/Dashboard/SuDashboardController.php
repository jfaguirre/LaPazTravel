<?php

namespace App\Http\Controllers\Super\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Sitio;
use App\Models\User;
use Illuminate\Http\Request;

class SuDashboardController extends Controller
{
    public function dashboard()
    {
        // --- Métricas KPI ---
        $totalUsuarios = User::count();
        $sitiosPendientesCount = Sitio::where('estado', 'PENDIENTE')->count();
        $totalSitiosActivos = Sitio::where('estado', 'APROBADO')->count();
        $totalVisitas = Sitio::sum('visitas');

        // --- Estados secundarios ---
        $sitiosRechazadosCount = Sitio::where('estado', 'RECHAZADO')->count();
        $sitiosSuspendidosCount = Sitio::where('estado', 'SUSPENDIDO')->count();

        // --- Sitios destacados por visitas ---
        $sitiosMasVisitados = Sitio::with('usuario')
            ->where('estado', 'APROBADO')
            ->orderByDesc('visitas')
            ->take(5)
            ->get();

        // --- Listados principales ---
        $sitiosPendientes = Sitio::with('usuario')
            ->where('estado', 'PENDIENTE')
            ->latest()
            ->take(5)
            ->get();

        $ultimosUsuarios = User::with('roles')
            ->latest()
            ->take(5)
            ->get();

        return view('super.dashboard', compact(
            'totalUsuarios',
            'sitiosPendientesCount',
            'totalSitiosActivos',
            'totalVisitas',
            'sitiosRechazadosCount',
            'sitiosSuspendidosCount',
            'sitiosMasVisitados',
            'sitiosPendientes',
            'ultimosUsuarios'
        ));
    }
}