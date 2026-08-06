<?php

namespace App\Http\Middleware;

use App\Models\Sitio;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DashboardSitio
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
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

        if($sitio->estado != 'APROBADO')
        {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
