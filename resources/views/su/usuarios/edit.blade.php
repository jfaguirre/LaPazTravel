@extends('layouts.su')
@section('title', 'Editar Usuario')

@section('contenido')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0 font-weight-bold">Editar Usuario</h1>
            <p class="text-muted mb-0">Modificar los accesos o datos de perfil de: <strong>{{ $usuario->name }}</strong></p>
        </div>
        <a href="{{ route('su.usuarios.index') }}" class="btn btn-outline-secondary font-weight-bold shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al Listado
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('su.usuarios.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row g-3">
                    <!-- Vista previa de foto actual -->
                    <div class="col-12 d-flex align-items-center mb-2">
                        <div class="me-3">
                            @if($usuario->foto_perfil)
                                <img src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Perfil" class="rounded-circle border" style="width: 70px; height: 70px; object-fit: cover;">
                            @else
                                <div class="bg-light rounded-circle d-flex align-items-center justify-content-center border text-secondary" style="width: 70px; height: 70px;">
                                    <i class="bi bi-person fs-2"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <span class="d-block small font-weight-bold text-muted text-uppercase">Imagen Actual</span>
                            <span class="text-muted small">ID de usuario: <code>{{ $usuario->id }}</code></span>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label small font-weight-bold text-muted text-uppercase">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="col-12 col-md-6">
                        <label for="lastName" class="form-label small font-weight-bold text-muted text-uppercase">Apellido</label>
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName', $usuario->lastName) }}" required>
                        @error('lastName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Correo -->
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label small font-weight-bold text-muted text-uppercase">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Rol -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="rol" class="form-label small font-weight-bold text-muted text-uppercase">Rol del Sistema</label>
                        <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}" {{ old('rol', $usuarioRol) == $rol->name ? 'selected' : '' }}>
                                    {{ $rol->name == 'su' ? 'Super Administrador (SU)' : ucfirst($rol->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="estado" class="form-label small font-weight-bold text-muted text-uppercase">Estado de la cuenta</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="ACTIVO" {{ old('estado', $usuario->estado) == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                            <option value="INACTIVO" {{ old('estado', $usuario->estado) == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
                            <option value="SUSPENDIDO" {{ old('estado', $usuario->estado) == 'SUSPENDIDO' ? 'selected' : '' }}>Suspendido</option>
                        </select>
                        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Cambiar Contraseña (Aviso de opcionalidad) -->
                    <div class="col-12 col-md-6 mt-4">
                        <label for="password" class="form-label small font-weight-bold text-muted text-uppercase">Nueva Contraseña <span class="text-lowercase text-normal font-weight-normal text-muted">(Dejar en blanco para no cambiar)</span></label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Escribe una nueva contraseña si deseas cambiarla">
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 col-md-6 mt-4">
                        <label for="password_confirmation" class="form-label small font-weight-bold text-muted text-uppercase">Confirmar Nueva Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repite la nueva contraseña">
                    </div>

                    <!-- Modificar Foto -->
                    <div class="col-12 mt-3">
                        <label for="foto_perfil" class="form-label small font-weight-bold text-muted text-uppercase">Reemplazar Foto de Perfil</label>
                        <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" id="foto_perfil" name="foto_perfil" accept="image/*">
                        @error('foto_perfil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr class="my-4">

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('su.usuarios.index') }}" class="btn btn-light font-weight-bold">Cancelar</a>
                    <button type="submit" class="btn btn-dark font-weight-bold shadow-sm">
                        <i class="bi bi-save-fill me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection