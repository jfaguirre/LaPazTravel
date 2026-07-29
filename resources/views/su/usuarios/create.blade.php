@extends('layouts.su')
@section('title', 'Crear Nuevo Usuario')

@section('contenido')
<div class="container py-5">
    <!-- Encabezado / Botón Regresar -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 text-gray-800 mb-0 font-weight-bold">Nuevo Usuario</h1>
            <p class="text-muted mb-0">Registrar un nuevo miembro en la plataforma</p>
        </div>
        <a href="{{ route('su.usuarios.index') }}" class="btn btn-outline-secondary font-weight-bold shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al Listado
        </a>
    </div>

    <!-- Tarjeta del Formulario -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">
            <form action="{{ route('su.usuarios.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-3">
                    <!-- Nombre -->
                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label small font-weight-bold text-muted text-uppercase">Nombre</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Ej. Juan Francisco" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="col-12 col-md-6">
                        <label for="lastName" class="form-label small font-weight-bold text-muted text-uppercase">Apellido</label>
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName') }}" placeholder="Ej. Aguirre" required>
                        @error('lastName')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Correo Electrónico -->
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label small font-weight-bold text-muted text-uppercase">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nombre@correo.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Asignación de Rol -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="rol" class="form-label small font-weight-bold text-muted text-uppercase">Asignar Rol</label>
                        <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                            <option value="" disabled selected>Selecciona un rol...</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}" {{ old('rol') == $rol->name ? 'selected' : '' }}>
                                    {{ $rol->name == 'su' ? 'Super Administrador (SU)' : ucfirst($rol->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Estado Inicial -->
                    <div class="col-12 col-sm-6 col-md-3">
                        <label for="estado" class="form-label small font-weight-bold text-muted text-uppercase">Estado</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="ACTIVO" {{ old('estado') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                            <option value="INACTIVO" {{ old('estado') == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
                            <option value="SUSPENDIDO" {{ old('estado') == 'SUSPENDIDO' ? 'selected' : '' }}>Suspendido</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Contraseña -->
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label small font-weight-bold text-muted text-uppercase">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="col-12 col-md-6">
                        <label for="password_confirmation" class="form-label small font-weight-bold text-muted text-uppercase">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña exactamente" required>
                    </div>

                    <!-- Foto de Perfil -->
                    <div class="col-12">
                        <label for="foto_perfil" class="form-label small font-weight-bold text-muted text-uppercase">Foto de Perfil (Opcional)</label>
                        <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" id="foto_perfil" name="foto_perfil" accept="image/*">
                        <div class="form-text text-muted">Formatos admitidos: JPG, PNG, WEBP. Tamaño máximo: 2MB.</div>
                        @error('foto_perfil')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4">

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('su.usuarios.index') }}" class="btn btn-light font-weight-bold">Cancelar</a>
                    <button type="submit" class="btn btn-dark font-weight-bold shadow-sm">
                        <i class="bi bi-person-plus-fill me-1"></i> Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection