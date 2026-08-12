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

            <div class="card-sitio" style="background-image: linear-gradient(rgba(0, 0, 0, 0.10), rgba(0, 0, 0, 0.10)), url('{{ asset('assets/images/default.webp') }}');">

                <section class="superior">
                    <div class="sitio-estado-info">
                        <span>{{ $sitio->estado }}</span>
                    </div>
                    <div class="verificacion">
                        <i class="bi bi-patch-check-fill icon-verificado"></i>
                    </div>
                </section>

                <section class="inferior">
                    <div class="contenido">
                        <h5>{{ $sitio->nombre }}</h5>
                        <p>{{ $sitio->descripcion_corta }}</p>
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
                            <a class="btn btn-dark" href="{{ route('perfil.session') }}" title="Vista previa">
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

