<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sitio;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\Models\Departamento;

class AdminController extends Controller
{
    // lista, busqueda y filtrado de todos los sitios de la plataforma
    public function sitiosIndex(Request $request)
    {
        // Iniciamos la consulta cargando las relaciones básicas necesarias para la tabla
        $query = Sitio::with(['usuario', 'perfil.departamento', 'perfil.distrito']);

        // Filtro: Búsqueda exacta o parcial (Nombre sitio, Nombre/Apellido del dueño o Email)
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

        // Filtro: Estado del Sitio
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        // Filtro: Ubicación por Departamento
        if ($request->filled('departamento')) {
            $query->whereHas('perfil', function ($p) use ($request) {
                $p->where('id_departamento', $request->input('departamento')); 
            });
        }

        // Paginamos los resultados (10 por página) y traemos los departamentos ordenados por nombre
        $sitios = $query->latest()->paginate(10);
        $departamentos = Departamento::orderBy('departamento', 'asc')->get();

        // Retornamos la vista que creamos
        return view('admin.sitios.index', compact('sitios', 'departamentos'));
    }

    // pantalla de revisión de un sitio específico, mostrando todos sus detalles y relaciones
    public function revisar($id)
    {
        // cargamos sitio traemos todo su perfil, ubicación, categorías, servicios, reglas, precios, imagenes, etc etc.
        $sitio = Sitio::with([
            'usuario', 
            'imagenes', // Relación con imagenes_sitios
            'perfil' => function($query) {
                $query->with([
                    'departamento',
                    'distrito',
                    'municipio',
                    'categorias', // sitio_categoria -> categorias
                    'servicios',  // sitio_servicio -> servicios
                    'reglas',     // sitio_regla -> reglas
                    'precios'     // precios vinculados al perfil
                ]);
            }
        ])->findOrFail($id);

        return view('admin.sitios.show', compact('sitio'));
    }

    // Accion para aprobar el sitio
    public function aprobar($id)
    {
        $sitio = Sitio::findOrFail($id);
        $sitio->estado = 'APROBADO'; // Cambia el estado a approbado
        $sitio->save();

        // redirigir al listado de sitios con el mensaje de exito
        return redirect()->route('admin.sitios.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido aprobado y publicado con éxito.");
    }

    // Accion para rechazar el sitio
    public function rechazar(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:1000',
        ]);

        $sitio = Sitio::findOrFail($id);
        $sitio->estado = 'RECHAZADO'; // Cambia el estado a RECHAZADO
        $sitio->save();

        // Si en el futuro se agrega un campo 'motivo_rechazo' agregar la logica aca
        //$sitio->motivo_rechazo = $request->motivo; $sitio->save();


        return redirect()->route('admin.sitios.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido rechazado. Razón: " . $request->motivo);
    }


    // Accion para suspender el sitio
    public function suspender(Request $request, $id)
    {
        $request->validate([
            'motivo' => 'required|string|max:1000'
        ]);

        $sitio = Sitio::findOrFail($id);
        

        $sitio->estado = 'SUSPENDIDO'; 
        $sitio->save();

        return redirect()->route('admin.sitios.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido suspendido con éxito.");
    }

    // Accion para devolver el sitio a revisión pendiente
    public function pendiente($id)
    {
        $sitio = Sitio::findOrFail($id);
        $sitio->estado = 'PENDIENTE';
        $sitio->save();

        return redirect()->route('admin.sitios.index')
            ->with('success', "El sitio '{$sitio->nombre}' ha sido devuelto a revisión pendiente.");
    }



    public function usuariosIndex(Request $request)
    {
        // Cargamos los usuarios con sus roles usando Eager Loading
        $query = User::with('roles'); 

        // Filtro por término de búsqueda (Nombre, Apellido, Email)
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('lastName', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        // Filtro por Rol usando las bondades de Spatie Laravel-Permission
        if ($request->filled('rol')) {
            $query->role($request->input('rol'));
        }

        // Paginamos manteniendo el orden y los parámetros de búsqueda en la URL
        $usuarios = $query->latest()->paginate(10);

        // Jalamos los roles directamente desde la tabla de Spatie para que el select sea dinámico
        $roles = Role::all();

        return view('admin.usuarios.index', compact('usuarios', 'roles'));
    }




}