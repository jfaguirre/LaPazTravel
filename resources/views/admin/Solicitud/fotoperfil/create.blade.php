@extends('layouts.app')
@section('title', 'Foto de Perfil - ' . $sitio->nombre)

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
    <style>
        .fotoperfil-container {
            max-width: 900px;
            margin: 0 auto;
        }
        .upload-zone {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            padding: 32px 20px;
            text-align: center;
            background: #f8fafc;
            cursor: pointer;
            transition: all 0.2s ease;
        }
        .upload-zone:hover {
            border-color: #0284c7;
            background: #f0f9ff;
        }
        .upload-icon {
            font-size: 40px;
            color: #0284c7;
            margin-bottom: 8px;
        }
        .upload-text {
            font-size: 15px;
            color: #334155;
            margin-bottom: 4px;
        }
        .upload-hint {
            font-size: 13px;
            color: #64748b;
        }
        .avatar-preview-box {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            border: 4px solid var(--primario);
            box-shadow: 0 8px 20px rgba(0,0,0,0.12);
            object-fit: cover;
            background-color: var(--neutro-100);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            margin: 0 auto;
        }
        .avatar-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .avatar-preview-box i {
            font-size: 64px;
            color: var(--neutro-400);
        }
    </style>
@endpush

@section('contenido')
<div id="page-dashboard" class="page">
    <div class="dashboard-card fotoperfil-container" style="padding: 40px;">

        <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Foto de perfil o logo del sitio</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Sube el logo o la imagen representativa de tu destino turístico <strong>{{ $sitio->nombre }}</strong>.</p>
            </div>
            <a href="{{ route('perfil.create') }}" class="step-link" style="font-size: 14.5px;">
                <i class="bi bi-arrow-left-short" style="font-size: 20px; line-height: 1;"></i> Volver al panel
            </a>
        </div>

        @if(session('error'))
            <div class="alert alert-danger mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger mb-4" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('fotoperfil.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Previsualización Actual / Dinámica -->
            @php
                $fotoPerfilUrl = $sitio->perfil && $sitio->perfil->foto_perfil ? asset($sitio->perfil->foto_perfil) : null;
            @endphp
            <div style="text-align: center; margin-bottom: 32px;">
                <label style="font-size: 14px; font-weight: 700; color: var(--neutro-800); display: block; margin-bottom: 12px;">Vista previa de la foto de perfil:</label>
                <div class="avatar-preview-box" id="avatar-container">
                    @if($fotoPerfilUrl)
                        <img src="{{ $fotoPerfilUrl }}" id="avatar-img" alt="Foto de Perfil">
                    @else
                        <i class="bi bi-person-fill" id="avatar-placeholder"></i>
                        <img src="" id="avatar-img" alt="Foto de Perfil" style="display: none;">
                    @endif
                </div>
            </div>

            <!-- Recomendaciones -->
            <div class="alert alert-info d-flex align-items-start gap-3 mb-4" style="background-color: #f0f9ff; border: 1px solid #bae6fd; color: #0369a1; border-radius: 12px; padding: 16px;">
                <i class="bi bi-info-circle-fill fs-5" style="color: #0284c7;"></i>
                <div>
                    <strong>Requisitos y recomendaciones para la foto de perfil:</strong>
                    <ul class="m-0 ps-3 mt-1" style="font-size: 13.5px; line-height: 1.5;">
                        <li>Formatos admitidos: <strong>JPG, JPEG, PNG o WEBP</strong>.</li>
                        <li>Tamaño máximo del archivo: <strong>2 MB</strong>.</li>
                        <li>Se recomienda una imagen cuadrada (ej: 400x400 px) con el logo o emblema claro del sitio.</li>
                    </ul>
                </div>
            </div>

            <!-- Arrastrar Drag & Drop -->
            <div class="upload-zone" id="drop-zone-fotoperfil" onclick="document.getElementById('input-foto-perfil').click()">
                <i class="bi bi-cloud-arrow-up-fill upload-icon"></i>
                <p class="upload-text"><strong>Haz clic aquí</strong> o arrastra la foto de perfil</p>
                <span class="upload-hint">Formatos: JPG, PNG, WEBP (Máx. 2MB)</span>
                <input type="file" name="foto_perfil" id="input-foto-perfil" accept="image/jpeg,image/png,image/jpg,image/webp" style="display: none;" onchange="handleFotoPerfilSelect(this)">
            </div>

            <!-- Mensaje de Error JS -->
            <div id="fotoperfil-file-error" class="text-danger mt-2 fw-bold text-center" style="display: none; font-size: 13px;"></div>

            <!-- Botones -->
            <div class="btn-actions" style="display: flex; align-items: center; justify-content: flex-end; gap: 16px; border-top: 2px solid var(--border); padding-top: 24px; margin-top: 32px;">
                <a href="{{ route('perfil.create') }}" class="btn-cancel" style="background-color: var(--blanco); border: 2px solid var(--border); color: var(--neutro-700); padding: 10px 24px; border-radius: var(--radius-md); font-size: 15px; font-weight: 700; text-decoration: none;">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit" id="btn-submit-fotoperfil" style="background-color: var(--primario); color: var(--blanco); border: none; padding: 12px 28px; border-radius: var(--radius-md); font-size: 15px; font-weight: 700; cursor: pointer;">
                    Guardar Cambios <i class="bi bi-check-lg ms-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handleFotoPerfilSelect(input) {
        const errorDiv = document.getElementById('fotoperfil-file-error');
        const avatarImg = document.getElementById('avatar-img');
        const avatarPlaceholder = document.getElementById('avatar-placeholder');
        
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';

        if (!input.files || !input.files[0]) return;

        const file = input.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];

        if (!validTypes.includes(file.type)) {
            errorDiv.textContent = 'El archivo debe ser una imagen válida (JPG, PNG, WEBP).';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            errorDiv.textContent = 'La foto de perfil no debe pesar más de 2 MB.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            avatarImg.src = e.target.result;
            avatarImg.style.display = 'block';
            if (avatarPlaceholder) {
                avatarPlaceholder.style.display = 'none';
            }
        };

        reader.readAsDataURL(file);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dropZone = document.getElementById('drop-zone-fotoperfil');
        if (!dropZone) return;

        ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, e => {
                e.preventDefault();
                e.stopPropagation();
            }, false);
        });

        ['dragenter', 'dragover'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.style.borderColor = '#0284c7', false);
        });

        ['dragleave', 'drop'].forEach(eventName => {
            dropZone.addEventListener(eventName, () => dropZone.style.borderColor = '#cbd5e1', false);
        });

        dropZone.addEventListener('drop', e => {
            const dt = e.dataTransfer;
            const files = dt.files;
            const input = document.getElementById('input-foto-perfil');
            if (files && files.length > 0) {
                input.files = files;
                handleFotoPerfilSelect(input);
            }
        }, false);
    });
</script>
@endpush
