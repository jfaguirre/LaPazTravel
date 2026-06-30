@extends('components.formularios')

@section('title', 'Login de usuario')
    
@section('contenedor_formulario')
    
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <h2>Iniciar sesion</h2>
    <!-- tiraba el siguiente error: The POST method is not supported for route /. Supported methods: GET, HEAD. -->
    <!-- debido a eso se cambio el metodo a GET -->
    <form method="POST" action="{{ route('login') }}" class="formulario">
        @csrf

        <!-- Email Address -->
        <div>            
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('register') }}">
                    {{ __('register') }}
                </a>
                <!-- se agrego un boton para registrarse -->
            <x-primary-button class="ms-3 btnAceptar">
                {{ __('Login') }} <!-- antes la ruta se llaba log in en lugar de login como esta en auth.php-->
            </x-primary-button>
        </div>
    </form>

@endsection
