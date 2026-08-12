<?php

namespace App\Http\Controllers\Super;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sitio;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Distrito;

class SuController extends Controller
{
    /**
     * Muestra el listado de sitios con filtros combinados (búsqueda, estado y ubicación).
     */
    public function sitioIndex(Request $request)
    {
        $query = Sitio::with(['usuario', 'perfil.departamento', 'perfil.municipio', 'perfil.distrito']);

        // 1. Filtro por búsqueda de texto
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nombre', 'LIKE', "%{$search}%")
                  ->orWhereHas('usuario', function ($u) use ($search) {
                      $u->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('lastName', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                  });
            });
        }

        // 2. Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // 3. Filtros por ubicación (jerárquico: Distrito > Municipio > Departamento)
        if ($request->filled('distrito_id')) {
            $query->whereHas('perfil', function ($p) use ($request) {
                $p->where('id_distrito', $request->input('distrito_id'));
            });
        } elseif ($request->filled('municipio_id')) {
            $query->whereHas('perfil', function ($p) use ($request) {
                $p->where('id_municipio', $request->input('municipio_id'));
            });
        } elseif ($request->filled('departamento')) {
            $query->whereHas('perfil', function ($p) use ($request) {
                $p->where('id_departamento', $request->input('departamento'));
            });
        }

        $sitios = $query->latest()->paginate(10)->withQueryString();

        // Si la petición es AJAX, responde únicamente con la tabla renderizada
        if ($request->ajax()) {
            return view('super.sitio.partials.tabla', compact('sitios'))->render();
        }

        $departamentos = Departamento::where('estado', '!=', 'INACTIVO')
            ->orderBy('departamento', 'asc')
            ->get();

        return view('super.sitio.index', compact('sitios', 'departamentos'));
    }

    // Métodos AJAX para la cascada dinámicos en los selects
    public function getMunicipios($departamentoId)
    {
        $municipios = Municipio::where('id_departamento', $departamentoId)
            ->where('estado', '!=', 'INACTIVO') // <-- Filtramos inactivos
            ->orderBy('municipio', 'asc')
            ->get();

        return response()->json($municipios);
    }

    public function getDistritos($municipioId)
    {
        // Al estar activo el municipio, traemos todos sus distritos directamente
        $distritos = Distrito::where('id_municipio', $municipioId)
            ->orderBy('distrito', 'asc')
            ->get();

        return response()->json($distritos);
    }


    // Pantalla de revisión de un sitio específico, mostrando todos sus detalles y relaciones
    public function revisar($id)
    {
        // Cargamos sitio con todo su perfil y ubicación
        $sitio = Sitio::with([
            'usuario', 
            'imagenes',
            'perfil' => function($query) {
                $query->with([
                    'departamento',
                    'distrito',
                    'municipio',
                    'categorias',
                    'servicios',
                    'reglas',
                    'precios'
                ]);
            }
        ])->findOrFail($id);

        return view('super.sitio.show', compact('sitio'));
    }

    // Acción para aprobar el sitio
    public function aprobar($id)
    {
        $sitio = Sitio::findOrFail($id);
        $sitio->estado = 'APROBADO';
        $sitio->save();

        return redirect()->route('super.sitio.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido aprobado y publicado con éxito.");
    }

    // Acción para rechazar el sitio
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:1000',
        ]);

        $sitio = Sitio::findOrFail($id);
        $sitio->estado = 'RECHAZADO';
        $sitio->save();

        return redirect()->route('super.sitio.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido rechazado. Razón: " . $request->motivo);
    }

    // Acción para suspender el sitio
    public function suspender(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:1000'
        ]);

        $sitio = Sitio::findOrFail($id);
        $sitio->estado = 'SUSPENDIDO'; 
        $sitio->save();

        return redirect()->route('super.sitio.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido suspendido con éxito.");
    }

    // Acción para devolver el sitio a revisión pendiente
    public function pendiente($id)
    {
        $sitio = Sitio::findOrFail($id);
        $sitio->estado = 'PENDIENTE';
        $sitio->save();

        return redirect()->route('super.sitio.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido devuelto a revisión pendiente.");
    }

}