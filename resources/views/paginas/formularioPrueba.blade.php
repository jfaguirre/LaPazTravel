@extends('components.formularios')

@section('title', 'Formulario de prueba - La Paz Travel')

@section('contenedor_formulario')
<div class="form-container">
            <h2>formulario de pruebas</h2>
            <form action="{{route('index')}}" method="POST">
                <label>Correo:</label>
                <input type="email" name="correo" required>
                <label>Contraseña:</label>
                <input type="password" name="password" required>
                <input class="btnAceptar" type="submit" value="verificar">
            </form>
            <br>
            <a class="back" href="{{route('index')}}">regresar</a>
</div>  

@endsection
