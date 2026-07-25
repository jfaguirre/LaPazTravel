@extends('components.formularios')

@section('title', 'Crear Cuenta - La Paz Travel')
    
@section('contenedor_formulario')
    
    <div class="form-header">
        <a href="{{ route('inicio') }}" class="form-logo">La Paz Travel</a>
        <h2>Crear Cuenta</h2>
        <p class="form-subtitle">Regístrate para comenzar a planificar tu viaje.</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="formulario">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <x-input-label for="name" :value="__('Nombre')" />
            <x-text-input id="name" class="form-input" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Tu nombre" />
            <x-input-error :messages="$errors->get('name')" class="form-error" />
        </div>

        <!-- LastName -->
        <div class="form-group">
            <x-input-label for="lastName" :value="__('Apellido')" />
            <x-text-input id="lastName" class="form-input" type="text" name="lastName" :value="old('lastName')" required autofocus autocomplete="lastName" placeholder="Tu apellido" />
            <x-input-error :messages="$errors->get('lastName')" class="form-error" />
        </div>

        <!-- Email Address -->
        <div class="form-group mt-4">
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ejemplo@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="form-error" />
        </div>

        <!-- Password -->
        <div class="form-group mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="Mínimo 8 caracteres" />
            <x-input-error :messages="$errors->get('password')" class="form-error" />
        </div>

        <!-- Confirm Password -->
        <div class="form-group mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmar Contraseña')" />
            <x-text-input id="password_confirmation" class="form-input"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="Repite tu contraseña" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="form-error" />
        </div>

        <div class="form-actions mt-4">
            <a class="form-link text-sm" href="{{ route('login') }}">
                {{ __('¿Ya tienes una cuenta?') }}
            </a>

            <div class="action-buttons">
                <a class="form-link-secondary" href="{{ route('login') }}">
                    {{ __('Iniciar Sesión') }}
                </a>
                <x-primary-button class="btn-submit">
                    {{ __('Registrarse') }}
                </x-primary-button>
            </div>
        </div>
    </form>
@endsection
