@extends('layouts.su')
@section('title', 'Editar Usuario')

@section('contenido')
<div class="container py-4">
    <!-- Ficha Principal de Edición -->
    <div class="card shadow-sm border-0 rounded-4 overflow-hidden">
        
        <!-- Header de la tarjeta -->
        <div class="card-header bg-light border-bottom py-3 px-4 d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('super.usuario.index') }}" class="btn btn-sm btn-white border shadow-sm rounded-circle p-2 d-inline-flex align-items-center justify-content-center" style="width: 38px; height: 38px;" title="Volver al listado">
                    <i class="bi bi-arrow-left text-secondary fs-6"></i>
                </a>
                <div>
                    <h5 class="fw-bold text-dark mb-0">Editar Perfil de Usuario</h5>
                    <small class="text-muted">Modificando la cuenta de <strong>{{ $usuario->name }} {{ $usuario->lastName }}</strong></small>
                </div>
            </div>
            <span class="badge bg-white text-secondary font-monospace border px-3 py-2 rounded-pill shadow-sm">
                ID: #{{ $usuario->id }}
            </span>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('super.usuario.update', $usuario->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Bloque Superior: Fotografía e Identificación -->
                <div class="row align-items-center mb-4 g-3 bg-light-subtle rounded-3 p-3 border border-dashed">
                    <div class="col-auto">
                        <div class="position-relative">
                            @if($usuario->foto_perfil)
                                <img id="avatarPreview" src="{{ asset('storage/' . $usuario->foto_perfil) }}" alt="Perfil" class="rounded-circle border border-2 border-white shadow" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div id="avatarFallback" class="bg-white rounded-circle d-flex align-items-center justify-content-center border shadow-sm text-secondary" style="width: 80px; height: 80px;">
                                    <i class="bi bi-person-fill fs-1"></i>
                                </div>
                                <img id="avatarPreview" src="#" alt="Perfil" class="rounded-circle border border-2 border-white shadow d-none" style="width: 80px; height: 80px; object-fit: cover;">
                            @endif
                        </div>
                    </div>
                    <div class="col-12 col-sm">
                        <label for="foto_perfil" class="form-label fw-semibold text-dark small mb-1">
                            <i class="bi bi-camera-fill text-success me-1"></i> Actualizar Avatar
                        </label>
                        <input type="file" class="form-control form-control-sm @error('foto_perfil') is-invalid @enderror" id="foto_perfil" name="foto_perfil" accept="image/*" onchange="previewImage(event)">
                        <div class="form-text small">Archivos permitidos: JPG, PNG, WEBP. Máximo 2MB.</div>
                        @error('foto_perfil') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <!-- Bloque: Información Personal -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="bg-success-subtle text-success p-2 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-person-vcard fs-6"></i>
                        </span>
                        <h6 class="fw-bold text-dark mb-0">Información General</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="name" class="form-label small fw-semibold text-secondary">Nombre(s)</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $usuario->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="lastName" class="form-label small fw-semibold text-secondary">Apellido(s)</label>
                            <input type="text" class="form-control @error('lastName') is-invalid @enderror" id="lastName" name="lastName" value="{{ old('lastName', $usuario->lastName) }}" required>
                            @error('lastName') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="email" class="form-label small fw-semibold text-secondary">Correo Electrónico</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-envelope"></i></span>
                                <input type="email" class="form-control border-start-0 ps-0 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $usuario->email) }}" required>
                            </div>
                            @error('email') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <hr class="text-muted opacity-25 my-4">

                <!-- Bloque: Permisos y Estatus -->
                <div class="mb-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <span class="bg-primary-subtle text-primary p-2 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                            <i class="bi bi-shield-check fs-6"></i>
                        </span>
                        <h6 class="fw-bold text-dark mb-0">Rol y Visibilidad</h6>
                    </div>

                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <label for="rol" class="form-label small fw-semibold text-secondary">Rol asignado</label>
                            <select class="form-select @error('rol') is-invalid @enderror" id="rol" name="rol" required>
                                @foreach($roles as $rol)
                                    <option value="{{ $rol->name }}" {{ old('rol', $usuarioRol) == $rol->name ? 'selected' : '' }}>
                                        {{ $rol->name == 'su' ? 'Super Administrador (SU)' : ucfirst($rol->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('rol') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 col-md-6">
                            <label for="estado" class="form-label small fw-semibold text-secondary">Estado de cuenta</label>
                            <select class="form-select @error('estado') is-invalid @enderror" id="estado" name="estado" required>
                                <option value="ACTIVO" {{ old('estado', $usuario->estado) == 'ACTIVO' ? 'selected' : '' }}>🟢 Activo</option>
                                <option value="INACTIVO" {{ old('estado', $usuario->estado) == 'INACTIVO' ? 'selected' : '' }}>🟡 Inactivo</option>
                                <option value="SUSPENDIDO" {{ old('estado', $usuario->estado) == 'SUSPENDIDO' ? 'selected' : '' }}>🔴 Suspendido</option>
                            </select>
                            @error('estado') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>

                <!-- ========================================================================= -->
                <!-- SECCIÓN CAMBIAR CONTRASEÑA (INVISIBLE / OCULTA TEMPORALMENTE)             -->
                <!-- Para volver a mostrarla, simplemente quita la clase 'd-none' del div     -->
                <!-- ========================================================================= -->
                <div class="d-none">
                    <hr class="text-muted opacity-25 my-4">
                    <div class="mb-4">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <span class="bg-warning-subtle text-warning-emphasis p-2 rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                <i class="bi bi-key fs-6"></i>
                            </span>
                            <h6 class="fw-bold text-dark mb-0">Cambiar Contraseña</h6>
                        </div>
                        <p class="text-muted small mb-3">Deja estos campos en blanco para mantener la contraseña actual.</p>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="password" class="form-label small fw-semibold text-secondary">Nueva Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="••••••••">
                                @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="password_confirmation" class="form-label small fw-semibold text-secondary">Confirmar Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="••••••••">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ========================================================================= -->

                <!-- Barra de Acciones del Formulario -->
                <div class="d-flex justify-content-end align-items-center gap-2 pt-3 border-top mt-4">
                    <a href="{{ route('super.usuario.index') }}" class="btn btn-light fw-semibold text-secondary px-3">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-success fw-semibold shadow-sm px-4">
                        <i class="bi bi-check-circle-fill me-1"></i> Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script para Previsualización dinámica de la foto de perfil -->
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