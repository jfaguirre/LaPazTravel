@extends('layouts.app')
@section('title', 'Dashboard')

@push('styles')
        @vite(['resources/css/dashboard_sitio.css'])
@endpush
    

@section('contenido')

<div id="page-dashboard" class="page">
    <div class="dashboard-card">
        <h1>Crea la ficha de tu sitio turístico</h1>
        <p>Registra la información principal de tu destino para que pueda ser explorado por miles de visitantes. Completa cada sección con datos precisos y reales. Una vez completada cada sección, podrás enviar la solicitud para que pueda ser revisada y aprobada.</p>
        <div class="form-actions">
            <a href="{{ route('sitio.create') }}" class="btn btn-dark boton">
                Iniciar ahora                
            </a>
        </div>
    </div>
</div>
    
@endsection

