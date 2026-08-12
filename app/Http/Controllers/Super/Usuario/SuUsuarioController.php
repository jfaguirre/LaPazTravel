<?php

namespace App\Http\Controllers\Super\Usuario;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuUsuarioController extends Controller
{
    /**
     * Muestra la lista de usuarios con búsquedas y filtros.
     */
    public function index(Request $request)
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

        // Filtro por Rol usando Spatie Laravel-Permission
        if ($request->filled('rol')) {
            $query->role($request->input('rol'));
        }

        // Paginamos manteniendo el orden y los parámetros de búsqueda en la URL
        $usuarios = $query->latest()->paginate(10);

        // Jalamos los roles directamente desde la tabla de Spatie para el select
        $roles = Role::all();

        return view('super.usuario.index', compact('usuarios', 'roles'));
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     */
    public function create()
    {
        $roles = Role::all();
        return view('super.usuario.create', compact('roles'));
    }

    /**
     * Guarda un nuevo usuario en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'lastName'    => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email',
            'password'    => 'required|string|min:8|confirmed',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'estado'      => ['required', Rule::in(['ACTIVO', 'INACTIVO', 'SUSPENDIDO'])],
            'rol'         => 'required|exists:roles,name',
        ]);

        $data = $request->only(['name', 'lastName', 'email', 'estado']);
        $data['password'] = Hash::make($request->password);

        // Manejo de la foto de perfil si se sube una
        if ($request->hasFile('foto_perfil')) {
            $data['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }

        // Creación del usuario
        $usuario = User::create($data);

        // Asignación del rol mediante Spatie
        $usuario->assignRole($request->rol);

        return redirect()->route('super.usuario.index')
            ->with('success', "El usuario {$usuario->name} {$usuario->lastName} ha sido creado con éxito.");
    }

    /**
     * Muestra los detalles de un usuario específico.
     */
    public function show($id)
    {
        // Cargamos el usuario junto con sus roles y opcionalmente sus sitios asociados
        $usuario = User::with(['roles', 'sitios'])->findOrFail($id);

        return view('super.usuario.show', compact('usuario'));
    }

    /**
     * Muestra el formulario para editar un usuario existente.
     */
    public function edit($id)
    {
        $usuario = User::findOrFail($id);
        $roles = Role::all();
        
        // Obtenemos el nombre del rol actual del usuario
        $usuarioRol = $usuario->roles->first()?->name;

        return view('super.usuario.edit', compact('usuario', 'roles', 'usuarioRol'));
    }

    /**
     * Actualiza el usuario en la base de datos.
     */
    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'lastName'    => 'required|string|max:255',
            'email'       => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($usuario->id)],
            'password'    => 'nullable|string|min:8|confirmed',
            'foto_perfil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'estado'      => ['required', Rule::in(['ACTIVO', 'INACTIVO', 'SUSPENDIDO'])],
            'rol'         => 'required|exists:roles,name',
        ]);

        $data = $request->only(['name', 'lastName', 'email', 'estado']);

        // Cambiar contraseña únicamente si el administrador digitó una nueva
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        // Manejo de cambio de imagen de perfil
        if ($request->hasFile('foto_perfil')) {
            // Eliminar foto antigua si existe en el disco público
            if ($usuario->foto_perfil && Storage::disk('public')->exists($usuario->foto_perfil)) {
                Storage::disk('public')->delete($usuario->foto_perfil);
            }
            $data['foto_perfil'] = $request->file('foto_perfil')->store('perfiles', 'public');
        }

        // Actualizar datos
        $usuario->update($data);

        // Sincronizar el rol con Spatie (reemplaza los anteriores por el nuevo elegido)
        $usuario->syncRoles([$request->rol]);

        return redirect()->route('super.usuario.index')
            ->with('success', "El usuario {$usuario->name} ha sido actualizado correctamente.");
    }

    /**
     * Elimina (o da de baja) un usuario del sistema.
     */
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);

        // Opcional: Impedir que el SuperAdmin logueado se elimine a sí mismo
        if (auth()->id() == $usuario->id) {
            return redirect()->route('super.usuario.index')
                ->with('error', 'No puedes eliminar tu propia cuenta de administrador.');
        }

        // Eliminar foto de perfil del almacenamiento físico si existe
        if ($usuario->foto_perfil && Storage::disk('public')->exists($usuario->foto_perfil)) {
            Storage::disk('public')->delete($usuario->foto_perfil);
        }

        $usuario->delete();

        return redirect()->route('super.usuario.index')
            ->with('success', "El usuario ha sido eliminado del sistema con éxito.");
    }
}