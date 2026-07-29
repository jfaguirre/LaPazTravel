@extends('layouts.su')
@section('title', 'Administración de Usuarios')

@section('contenido')
<div class="container py-5">
    
    <!-- Banner Delgado de Notificación Integrado -->
    @if(session('success'))
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden position-relative" style="background: #f0fdf4; border-left: 5px solid #22c55e !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 32px; height: 32px; background-color: #22c55e;">
                        <i class="bi bi-check-lg fs-6"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-dark d-block" style="font-size: 13px;">Confirmación del Sistema</span>
                        <span class="text-secondary small">{{ session('success') }}</span>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light border-0 rounded-circle text-muted p-1 d-flex align-items-center justify-content-center" onclick="this.closest('.card').remove()" style="width: 28px; height: 28px;">
                    <i class="bi bi-x-lg" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden position-relative" style="background: #fef2f2; border-left: 5px solid #ef4444 !important;">
            <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center text-white shadow-sm" style="width: 32px; height: 32px; background-color: #ef4444;">
                        <i class="bi bi-exclamation-lg fs-6"></i>
                    </div>
                    <div>
                        <span class="fw-bold text-dark d-block" style="font-size: 13px;">Error en la Operación</span>
                        <span class="text-secondary small">{{ session('error') }}</span>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-light border-0 rounded-circle text-muted p-1 d-flex align-items-center justify-content-center" onclick="this.closest('.card').remove()" style="width: 28px; height: 28px;">
                    <i class="bi bi-x-lg" style="font-size: 12px;"></i>
                </button>
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0 font-weight-bold">Control de Usuarios</h1>
            <p class="text-muted mb-0">Listado, filtrado y asignación de roles para los usuarios del sistema</p>
        </div>
        <div>
            <a href="{{ route('su.usuarios.create') }}" class="btn btn-dark font-weight-bold shadow-sm">
                <i class="bi bi-person-plus-fill me-1"></i> Nuevo Usuario
            </a>
        </div>
    </div>

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body p-4">
            <form action="{{ route('su.usuarios.index') }}" method="GET" class="row g-3">
                
                <div class="col-12 col-md-6">
                    <label for="search" class="form-label small font-weight-bold text-muted text-uppercase">Buscar Usuario</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-search"></i></span>
                        <input type="text" class="form-control bg-light border-start-0" id="search" name="search" value="{{ request('search') }}" placeholder="Nombre, apellido o correo electrónico...">
                    </div>
                </div>

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

                <div class="col-12 col-sm-6 col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-dark w-100 font-weight-bold shadow-sm">
                        <i class="bi bi-funnel-fill me-1"></i> Filtrar
                    </button>
                    @if(request()->hasAny(['search', 'rol']))
                        <a href="{{ route('su.usuarios.index') }}" class="btn btn-outline-secondary" title="Limpiar filtros">
                            <i class="bi bi-arrow-counterclockwise"></i>
                        </a>
                    @endif
                </div>

            </form>
        </div>
    </div>

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
                                <td class="px-4 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                            @if($usuario->foto_perfil)
                                                <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Perfil" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                            @else
                                                <i class="bi bi-person text-secondary fs-5"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-weight-semibold text-dark">{{ $usuario->name }} {{ $usuario->lastName }}</div>
                                            <span class="text-muted small">ID: <code>{{ $usuario->id }}</code></span>
                                        </div>
                                    </div>
                                </td>
                                
                                <td class="px-4 py-3 text-muted">
                                    <div class="text-dark font-weight-medium">{{ $usuario->email }}</div>
                                    @if(isset($usuario->telefono))
                                        <span class="small d-block"><i class="bi bi-telephone text-muted me-1"></i>{{ $usuario->telefono }}</span>
                                    @endif
                                </td>
                                
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

                                <td class="px-4 py-3 text-center text-muted small">
                                    {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'N/D' }}
                                </td>
                                
                                <td class="px-4 py-3 text-end">
                                    <div class="btn-group shadow-sm">
                                        <a href="{{ route('su.usuarios.show', $usuario->id) }}" class="btn btn-sm btn-outline-dark" title="Ver Detalles">
                                            <i class="bi bi-eye-fill"></i>
                                        </a>
                                        <a href="{{ route('su.usuarios.edit', $usuario->id) }}" class="btn btn-sm btn-outline-dark" title="Editar Usuario">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <!-- Botón que activa el Modal de Confirmación -->
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Eliminar Usuario"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#modalEliminarUsuario"
                                                data-usuario-id="{{ $usuario->id }}"
                                                data-usuario-nombre="{{ $usuario->name }} {{ $usuario->lastName }}">
                                            <i class="bi bi-trash-fill"></i>
                                        </button>
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
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        @if($usuarios->hasPages())
            <div class="card-footer bg-white border-top-0 py-3 px-4 d-flex justify-content-center">
                {{ $usuarios->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Modal de Confirmación de Eliminación -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-body p-4 text-center">
                <div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 64px; height: 64px;">
                    <i class="bi bi-exclamation-triangle-fill fs-2"></i>
                </div>

                <h5 class="fw-bold text-dark mb-2" id="modalEliminarLabel">Confirmar Eliminación</h5>
                <p class="text-muted small mb-4">
                    ¿Estás seguro de que deseas eliminar al usuario <strong id="nombreUsuarioEliminar" class="text-dark"></strong>? Esta acción no se puede deshacer.
                </p>

                <form id="formEliminarUsuario" action="" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-light rounded-pill px-4 fw-semibold border" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger rounded-pill px-4 fw-semibold shadow-sm">Sí, Eliminar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script para pasar dinámicamente los datos al Modal -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEliminar = document.getElementById('modalEliminarUsuario');
        if (modalEliminar) {
            modalEliminar.addEventListener('show.bs.modal', function (event) {
                const button = event.relatedTarget;
                const id = button.getAttribute('data-usuario-id');
                const nombre = button.getAttribute('data-usuario-nombre');

                modalEliminar.querySelector('#nombreUsuarioEliminar').textContent = nombre;

                const form = modalEliminar.querySelector('#formEliminarUsuario');
                form.action = `{{ url('su/usuarios') }}/${id}`;
            });
        }
    });
</script>
@endsection