@extends('layouts.app')
@section('title', 'Imagen de Portada - ' . $sitio->nombre)

@push('styles')
    @vite(['resources/css/dashboard_sitio.css'])
    <style>
        .portada-container {
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
        .hero-card-preview {
            border-radius: 14px;
            padding: 24px;
            color: #ffffff;
            min-height: 180px;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
            transition: background-image 0.3s ease;
        }
        .preview-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(4px);
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        .preview-title {
            font-size: 22px;
            font-weight: 800;
            margin: 0 0 4px 0;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        .preview-desc {
            font-size: 13px;
            margin: 0;
            opacity: 0.9;
            text-shadow: 0 1px 3px rgba(0,0,0,0.5);
        }
    </style>
@endpush

@section('contenido')
<div id="page-dashboard" class="page">
    <div class="dashboard-card portada-container" style="padding: 40px;">

        <!-- Cabecera -->
        <div style="margin-bottom: 32px; border-bottom: 2px solid var(--border); padding-bottom: 20px; display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 16px;">
            <div>
                <h1 style="font-size: 26px; font-weight: 800; color: var(--neutro-900); margin: 0;">Imagen de portada del sitio</h1>
                <p style="font-size: 15px; color: var(--neutro-500); margin: 6px 0 0 0;">Sube una imagen panorámica de alta calidad para destacar tu sitio <strong>{{ $sitio->nombre }}</strong>.</p>
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

        <form action="{{ route('portada.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Recomendaciones -->
            <div class="alert alert-info d-flex align-items-start gap-3 mb-4" style="background-color: #f0f9ff; border: 1px solid #bae6fd; color: #0369a1; border-radius: 12px; padding: 16px;">
                <i class="bi bi-info-circle-fill fs-5" style="color: #0284c7;"></i>
                <div>
                    <strong>Requisitos y recomendaciones para la portada:</strong>
                    <ul class="m-0 ps-3 mt-1" style="font-size: 13.5px; line-height: 1.5;">
                        <li>Formatos admitidos: <strong>JPG, JPEG, PNG o WEBP</strong>.</li>
                        <li>Tamaño máximo del archivo: <strong>5 MB</strong>.</li>
                        <li>Resolución mínima recomendada: <strong>800 x 300 píxeles</strong> (Proporción horizontal 3:1).</li>
                    </ul>
                </div>
            </div>

            <!-- Arrastrar Drag & Drop -->
            <div class="upload-zone" id="drop-zone-portada" onclick="document.getElementById('input-foto-portada').click()">
                <i class="bi bi-cloud-arrow-up-fill upload-icon"></i>
                <p class="upload-text"><strong>Haz clic aquí</strong> o arrastra la imagen de portada</p>
                <span class="upload-hint">Formatos: JPG, PNG, WEBP (Máx. 5MB)</span>
                <input type="file" name="foto_portada" id="input-foto-portada" accept="image/jpeg,image/png,image/jpg,image/webp" style="display: none;" onchange="handlePortadaFileSelect(this)">
            </div>

            <!-- Mensaje de Error JS -->
            <div id="portada-file-error" class="text-danger mt-2 fw-bold" style="display: none; font-size: 13px;"></div>

            <!-- Previsualización en Tiempo Real -->
            @php
                $portadaUrl = $sitio->perfil && $sitio->perfil->foto_portada ? asset($sitio->perfil->foto_portada) : null;
            @endphp
            <div class="preview-container mt-4">
                <label style="font-size: 14px; font-weight: 700; color: var(--neutro-800); display: block; margin-bottom: 8px;">Vista previa del encabezado:</label>
                <div class="hero-card-preview" id="hero-preview-box" style="background: {{ $portadaUrl ? 'linear-gradient(rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.65)), url(' . $portadaUrl . ')' : 'linear-gradient(135deg, #0F52BA 0%, #1E6FE0 100%)' }}; background-size: cover; background-position: center;">
                    <div class="preview-badge">
                        <span>PORTADA DEL SITIO</span>
                    </div>
                    <h3 class="preview-title">{{ $sitio->nombre }}</h3>
                    <p class="preview-desc">{{ \Illuminate\Support\Str::limit($sitio->descripcion_corta ?? 'Descripción del sitio...', 90) }}</p>
                </div>
            </div>

            <!-- Botones -->
            <div class="btn-actions" style="display: flex; align-items: center; justify-content: flex-end; gap: 16px; border-top: 2px solid var(--border); padding-top: 24px; margin-top: 32px;">
                <a href="{{ route('perfil.create') }}" class="btn-cancel" style="background-color: var(--blanco); border: 2px solid var(--border); color: var(--neutro-700); padding: 10px 24px; border-radius: var(--radius-md); font-size: 15px; font-weight: 700; text-decoration: none;">
                    Cancelar
                </a>
                <button type="submit" class="btn-submit" id="btn-submit-portada" style="background-color: var(--primario); color: var(--blanco); border: none; padding: 12px 28px; border-radius: var(--radius-md); font-size: 15px; font-weight: 700; cursor: pointer;">
                    Guardar Cambios <i class="bi bi-check-lg ms-1"></i>
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function handlePortadaFileSelect(input) {
        const errorDiv = document.getElementById('portada-file-error');
        const previewBox = document.getElementById('hero-preview-box');
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

        if (file.size > 5 * 1024 * 1024) {
            errorDiv.textContent = 'La imagen no debe pesar más de 5 MB.';
            errorDiv.style.display = 'block';
            input.value = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = function(e) {
            const img = new Image();
            img.src = e.target.result;

            img.onload = function() {
                if (img.width < 800 || img.height < 300) {
                    errorDiv.textContent = `La imagen mide ${img.width}x${img.height}px. Se requiere al menos 800x300px.`;
                    errorDiv.style.display = 'block';
                    input.value = '';
                    return;
                }

                previewBox.style.backgroundImage = `linear-gradient(rgba(0, 0, 0, 0.35), rgba(0, 0, 0, 0.65)), url('${e.target.result}')`;
            };
        };

        reader.readAsDataURL(file);
    }

    document.addEventListener('DOMContentLoaded', () => {
        const dropZone = document.getElementById('drop-zone-portada');
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
            const input = document.getElementById('input-foto-portada');
            if (files && files.length > 0) {
                input.files = files;
                handlePortadaFileSelect(input);
            }
        }, false);
    });
</script>
@endpush
