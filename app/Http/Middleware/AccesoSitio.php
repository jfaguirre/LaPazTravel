<?php

namespace App\Http\Middleware;

use App\Models\Sitio;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccesoSitio
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {        
        $id_sitio = session('id_sitio');        
        
        // Si no está el id_sitio en la sesión pero el usuario está autenticado, intentamos recuperarlo
        if (!$id_sitio && Auth::check()) {
            $sitio = Sitio::where('id_user', Auth::id())->first();
            if ($sitio) {
                session(['id_sitio' => $sitio->id]);
                $id_sitio = $sitio->id;
            }
        } else {
            $sitio = Sitio::find($id_sitio);
        }

        if (!$sitio) {
            return redirect()->route('perfil.inicio');
        }
        
        // Si el estado del sitio no es BORRADOR (por ejemplo, está en PENDIENTE o APROBADO),
        // bloqueamos las rutas de edición redirigiendo a la vista correspondiente.
        if ($sitio->estado !== 'BORRADOR') {
            // Si el sitio está APROBADO, permitimos el acceso únicamente al dashboard.
            // Redirigimos a la ruta 'dashboard' si intentan acceder a otras rutas protegidas.
            if ($sitio->estado === 'APROBADO') {
                if ($request->routeIs('dashboard')) {
                    return $next($request);
                }
                return redirect()->route('dashboard');
            }

            return redirect()->route('perfil.create');
        }
        
        return $next($request);
    }
}
