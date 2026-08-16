@extends('layouts.app')
@section('title', 'Dashboard')


@section('sidebar')
    @include('components.sidebar-sitio')
@endsection

@section('contenido')

<div id="page-dashboard" class="page">
    <div class="dashboard-card">
        <div class="dashboard-grid">

           @forelse ($sitios as $sitio)
           
            <div class="card-sitio" style="background-image: linear-gradient(rgba(0, 0, 0, 0.10), rgba(16, 69, 214, 0.1)), url('{{ $sitio->perfil->foto_portada ? asset($sitio->perfil->foto_portada) : asset('assets/images/default.webp') }}');">
            {{-- <div class="card-sitio" style="background-image: linear-gradient(rgba(0, 0, 0, 0.10), rgba(16, 69, 214, 0.1)), url('{{ $sitio->perfil->foto_portada ? asset($sitio->perfil->foto_portada) : asset('assets/images/default.webp') }}');"> --}}

                <section class="superior">                  
                    <div class="{{ match($sitio->estado) {
                        'APROBADO'   => 'sitio-estado-aprobado',
                        'BORRADOR'   => 'sitio-estado-borrador',
                        'PENDIENTE'  => 'sitio-estado-pendiente',
                        'RECHAZADO'  => 'sitio-estado-rechazado',
                        'SUSPENDIDO' => 'sitio-estado-suspendido',
                        default => '',
                        } }}">
                        {{ $sitio->estado }}
                    </div>
                    <div class="verificacion">                                                
                        <i class="bi bi-patch-check-fill icon-verificado"></i>
                    </div>
                </section>

                <section class="inferior">
                    <div class="contenido">
                        <h5 class="{{ $sitio->perfil->foto_portada ? 'titulo_card' : ''}}">{{ $sitio->nombre }}</h5>
                        <p class="{{ $sitio->perfil->foto_portada ? 'parrafo_card' : ''}}">{{ $sitio->descripcion_corta }}</p>
                    </div>

                    <div class="estados">
                        <div class="estado-acciones">
                            <form action="{{ route('perfil.session') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_sitio" value="{{ $sitio->id }}">
                            <button type="submit" class="btn btn-dark" title="Editar sitio">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </form>
                            <a class="btn btn-dark" href="{{ route('sitio.show', $sitio->slug) }}" title="Vista previa">
                                <i class="bi bi-eye"></i>
                            </a>
                        </div>
                    </div>
                </section>

            </div>

        @empty
        @endforelse
            <a href="{{ route('sitio.create') }}">
                <div class="card-add-sitio">
                    <i class="bi bi-plus-circle-fill icon-mas-sitios"></i>
                </div>
            </a>
        </div>
    </div>
</div>

@endsection

