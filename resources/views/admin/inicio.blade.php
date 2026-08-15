@extends('layouts.app')
@section('title', 'Inicio')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
@endpush

@section('contenido')
    <div id="page-dashboard" class="page">
    <div class="dashboard-card">
        <!-- Alertas de estado -->
        @if(session('success'))
            <div class="alert alert-success" style="padding: 12px; margin-bottom: 24px; border-radius: 8px; border: 1px solid #c3e6cb; background-color: #d4edda; color: #155724; font-size: 14px; font-weight: 500;">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" style="padding: 12px; margin-bottom: 24px; border-radius: 8px; border: 1px solid #f5c6cb; background-color: #f8d7da; color: #721c24; font-size: 14px; font-weight: 500;">
                {{ session('error') }}
            </div>
        @endif

        <div class="dashboard-grid">
            <div class="dashboard-left">
                <h1>Crea la ficha de tu sitio turístico</h1>
                <p>Registra la información principal de tu destino para que pueda ser explorado por miles de visitantes. Completa cada sección con datos precisos y reales. Una vez completada cada sección, podrás enviar la solicitud para que pueda ser revisada y aprobada.</p>
                <div class="form-actions" style="margin-top: 10px; justify-content: flex-start;">
                    <a href="{{ route('perfil.create') }}" class="btn btn-dark boton">
                        Iniciar ahora
                    </a>
                </div>
            </div>
            <div class="imagen">
                <img src="{{ asset('assets/images/sitio_create.svg') }}" alt="Crear sitio">
            </div>
        </div>       

    </div>
</div>
@endsection
