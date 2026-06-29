@extends('components.formularios')

@section('title', 'Formulario de prueba - La Paz Travel')

@section('contenedor_formulario')
<div class="form-container">
            <h2>iniciar sesion</h2>
            <form action="#" method="POST">
                <label>Correo:</label>
                <input type="email" name="correo" required>
                <label>Contraseña:</label>
                <input type="password" name="password" required>
                <input type="submit" value="verificar">
            </form>
            <a type="back" href="{{route('index')}}">regresar</a>
</div>  

@endsection
