@extends('components.formularios')

@section('title', 'Iniciar Sesión - La Paz Travel')
    
@section('contenedor_formulario')
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    
    <div class="form-header">
        <a href="{{ route('inicio') }}" class="form-logo">La Paz Travel</a>
        <h2>Iniciar Sesión</h2>
        <p class="form-subtitle">Bienvenido de nuevo. Por favor ingresa tus datos.</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="formulario">
        @csrf

        <!-- Email Address -->
        <div class="form-group">            
            <x-input-label for="email" :value="__('Correo Electrónico')" />
            <x-text-input id="email" class="form-input" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="ejemplo@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="form-error" />
        </div>

        <!-- Password -->
        <div class="form-group mt-4">
            <x-input-label for="password" :value="__('Contraseña')" />
            <x-text-input id="password" class="form-input"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="form-error" />
        </div>

        <!-- Remember Me -->
        <div class="form-remember mt-4">
            <label for="remember_me" class="remember-label">
                <input id="remember_me" type="checkbox" class="remember-checkbox" name="remember">
                <span class="remember-text">{{ __('Recordarme en este equipo') }}</span>
            </label>
        </div>

        <div class="form-actions mt-4">
            @if (Route::has('password.request'))
                <a class="form-link text-sm" href="{{ route('password.request') }}">
                    {{ __('¿Olvidaste tu contraseña?') }}
                </a>
            @endif
            
            <div class="action-buttons">
                <a class="form-link-secondary" href="{{ route('register') }}">
                    {{ __('Registrarse') }}
                </a>
                <x-primary-button class="btn-submit">
                    {{ __('Ingresar') }}
                </x-primary-button>
            </div>
        </div>
    </form>

@endsection
