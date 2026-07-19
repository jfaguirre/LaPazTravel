@extends('layouts.app')
@section('title', 'Administración de Usuarios')

@section('contenido')
<div class="container py-5">
    
    <!-- Alertas de estado -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Título de sección -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0 font-weight-bold">Control de Usuarios</h1>
            <p class="text-muted mb-0">Listado, filtrado y asignación de roles para los usuarios del sistema</p>
        </div>
        <!-- Botón crear usuarios -->
        <div>
            <a href="{{ route('admin.usuarios.index') }}" class="btn btn-dark font-weight-bold shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    <!-- Tarjeta de filtros-->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('admin.usuarios.index') }}" method="GET" class="row g-3">
                
                <!-- buscar por palabra clave -->
                <div class="col-12 col-md-6">
                    <label for="search" class="form-label small font-weight-bold text-muted text-uppercase">Buscar Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" id="search" name="search" value="{{ request('search') }}" placeholder="Nombre, apellido o correo electrónico...">
                    </div>
                </div>

                <!-- Filtrar por Rol (Dinámico desde Spatie) -->
                <div class="col-12 col-sm-6 col-md-4">
                    <label for="rol" class="form-label small font-weight-bold text-muted text-uppercase">Rol del Usuario</label>
                    <select class="form-select bg-light" id="rol" name="rol">
                        <option value="">Todos los roles</option>
                        @foreach($roles as $rol)
                            <option value="{{ $rol->name }}" {{ request('rol') == $rol->name ? 'selected' : '' }}>
                                {{ $rol->name == 'su' ? 'Super Administrador (SU)' : ucfirst($rol->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Botones filtrar -->
                <div class="col-12 col-sm-6 col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark w-100 font-weight-bold shadow-sm">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                    @if(request()->hasAny(['search', 'rol']))
                        <a href="{{ route('admin.usuarios.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

    <!-- Tabla Principal de Usuarios -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 text-nowrap">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Contacto</th>
                            <th class="px-4 py-3 text-center">Rol</th>
                            <th class="px-4 py-3 text-center">Fecha Registro</th>
                            <th class="px-4 py-3 text-end">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($usuarios as $usuario)
                            <tr>
                                <!-- Nombre y Apellido -->
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            <i class="bi bi-person text-secondary fs-5"></i>
                                        </div>
                                        <div>
                                            <div class="font-weight-semibold text-dark">{{ $usuario->name }} {{ $usuario->lastName }}</div>
                                            <span class="text-muted small">ID: <code>{{ $usuario->id }}</code></span>
                                        </div>
                                    </div>
                                </td>
                                
                                <!-- Correo / Contacto -->
                                <td class="px-4 py-3 text-muted">
                                    <div class="text-dark font-weight-medium">{{ $usuario->email }}</div>
                                    @if(isset($usuario->telefono))
                                        <span class="small d-block"><i class="bi bi-telephone text-muted me-1"></i>{{ $usuario->telefono }}</span>
                                    @endif
                                </td>
                                
                                <!-- Badge de Rol Dinámico (Spatie) -->
                                <td class="px-4 py-3 text-center">
                                    @forelse($usuario->roles as $rol)
                                        @if($rol->name === 'su')
                                            <span class="badge bg-danger px-3 py-2 font-weight-bold">
                                                <i class="bi bi-shield-lock-fill me-1"></i> Administrador (SU)
                                            </span>
                                        @elseif($rol->name === 'admin')
                                            <span class="badge bg-primary px-3 py-2 font-weight-bold">
                                                <i class="bi bi-briefcase-fill me-1"></i> Admin
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 font-weight-bold">
                                                <i class="bi bi-person-fill me-1"></i> {{ ucfirst($rol->name) }}
                                            </span>
                                        @endif
                                    @empty
                                        <span class="badge bg-light text-dark border px-3 py-2 font-weight-bold">
                                            <i class="bi bi-person-fill me-1"></i> Sin Rol
                                        </span>
                                    @endforelse
                                </td>

                                <!-- Fecha de registro -->
                                <td class="px-4 py-3 text-center text-muted small">
                                    {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/D' }}
                                </td>
                                
                                <!-- Acciones -->
                                <td class="px-4 py-3 text-end">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('admin.usuarios.index', $usuario->id) }}" class="btn btn-sm btn-outline-dark" title="Editar Usuario">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <a href="{{ route('admin.usuarios.index', $usuario->id) }}" class="btn btn-sm btn-outline-dark" title="Ver Detalles">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-5 text-center text-muted">
                                    <i class="bi bi-person-x fs-1 d-block mb-2 text-secondary"></i>
                                    No se encontraron usuarios que coincidan con los criterios de búsqueda.
                                </td>
                            </tr>
                        @endempty
                    </tbody>
                </table>
            </div>
        </div>
        
        <!-- Paginación (Laravel Links) -->
        @if($usuarios->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 px-4 d-flex justify-content-center">
                {{ $usuarios->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>
@endsection