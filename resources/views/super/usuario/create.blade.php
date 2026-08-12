@extends('layouts.su')
@section('title', 'Crear Nuevo Usuario')

@section('contenido')
<div class="container py-4">
    <!-- Header y Navegación -->
    <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1">Nuevo Usuario</h4>
            <p class="text-muted small mb-0">Registrar un nuevo miembro en la plataforma</p>
        </div>
        <a href="{{ route('super.usuario.index') }}" class="btn btn-outline-secondary btn-sm fw-semibold shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> Volver al listado
        </a>
    </div>

    <!-- Formulario Principal -->
    <div class="card shadow-sm border-0 rounded-3">
        <div class="card-body p-4">
            <form action="{{ route('super.usuario.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Contenedor para Previsualización de Foto -->
                <div class="bg-light rounded-3 p-3 mb-4 d-flex align-items-center gap-3 border">
                    <div class="position-relative">
                        <div id="avatarFallback" class="bg-white rounded-circle d-flex align-items-center justify-content-center border text-secondary shadow-sm" style="width: 72px; height: 72px;">
                            <i class="bi bi-person-plus-fill fs-2"></i>
                        </div>
                        <img id="avatarPreview" src="#" alt="Vista previa" class="rounded-circle border border-white shadow-sm d-none" style="width: 72px; height: 72px; object-fit: cover;">
                    </div>
                    <div>
                        <span class="d-block fw-semibold text-dark small mb-1">Fotografía del Nuevo Usuario</span>
                        <span class="text-muted small">Carga opcional de avatar de perfil</span>
                    </div>
                </div>

                <!-- Sección 1: Datos Personales -->
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-person-lines-fill me-2 text-primary"></i>Datos Personales
                </h6>
                
                <div class="row g-3 mb-4">
                    <!-- Nombre -->
                    <div class="col-12 col-md-6">
                        <label for="name" class="form-label small fw-semibold text-muted">Nombre(s)</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Ej. Juan Francisco" required>
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Apellido -->
                    <div class="col-12 col-md-6">
                        <label for="lastName" class="form-label small fw-semibold text-muted">Apellido(s)</label>
                        <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName') }}" placeholder="Ej. Aguirre" required>
                        @error('lastName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Correo -->
                    <div class="col-12 col-md-6">
                        <label for="email" class="form-label small fw-semibold text-muted">Correo Electrónico</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="nombre@correo.com" required>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Foto de Perfil -->
                    <div class="col-12 col-md-6">
                        <label for="foto_perfil" class="form-label small fw-semibold text-muted">Foto de Perfil (Opcional)</label>
                        <input type="file" class="form-control @error('foto_perfil') is-invalid @enderror" id="foto_perfil" name="foto_perfil" accept="image/*" onchange="previewImage(event)">
                        <div class="form-text small text-muted">Formatos admitidos: JPG, PNG, WEBP (Máx. 2MB)</div>
                        @error('foto_perfil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr class="text-muted opacity-25 my-4">

                <!-- Sección 2: Rol y Estado -->
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-shield-check me-2 text-primary"></i>Roles y Accesos
                </h6>

                <div class="row g-3 mb-4">
                    <!-- Rol -->
                    <div class="col-12 col-md-6">
                        <label for="rol" class="form-label small fw-semibold text-muted">Asignar Rol</label>
                        <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                            <option value="" disabled selected>Selecciona un rol...</option>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->name }}" {{ old('rol') == $rol->name ? 'selected' : '' }}>
                                    {{ $rol->name == 'su' ? 'Super Administrador (SU)' : ucfirst($rol->name) }}
                                </option>
                            @endforeach
                        </select>
                        @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Estado -->
                    <div class="col-12 col-md-6">
                        <label for="estado" class="form-label small fw-semibold text-muted">Estado Inicial</label>
                        <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                            <option value="ACTIVO" {{ old('estado', 'ACTIVO') == 'ACTIVO' ? 'selected' : '' }}>Activo</option>
                            <option value="INACTIVO" {{ old('estado') == 'INACTIVO' ? 'selected' : '' }}>Inactivo</option>
                            <option value="SUSPENDIDO" {{ old('estado') == 'SUSPENDIDO' ? 'selected' : '' }}>Suspendido</option>
                        </select>
                        @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <hr class="text-muted opacity-25 my-4">

                <!-- Sección 3: Seguridad / Contraseña -->
                <h6 class="fw-bold text-dark mb-3">
                    <i class="bi bi-key-fill me-2 text-primary"></i>Seguridad de la Cuenta
                </h6>

                <div class="row g-3">
                    <!-- Contraseña -->
                    <div class="col-12 col-md-6">
                        <label for="password" class="form-label small fw-semibold text-muted">Contraseña</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Mínimo 8 caracteres" required>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Confirmar Contraseña -->
                    <div class="col-12 col-md-6">
                        <label for="password_confirmation" class="form-label small fw-semibold text-muted">Confirmar Contraseña</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Repite la contraseña" required>
                    </div>
                </div>

                <hr class="text-muted opacity-25 my-4">

                <!-- Botones de Acción -->
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('super.usuario.index') }}" class="btn btn-light fw-semibold text-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-success fw-semibold shadow-sm px-4">
                        <i class="bi bi-person-plus-fill me-1"></i> Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para Previsualizar la foto subida -->
<script>
    function previewImage(event) {
        const input = event.target;
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                const fallback = document.getElementById('avatarFallback');
                
                preview.src = e.target.result;
                preview.classList.remove('d-none');
                
                if (fallback) {
                    fallback.classList.add('d-none');
                }
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection