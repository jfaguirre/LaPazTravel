<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Título dinámico con valor por defecto -->
    <title>@yield('titulo', 'Formulario - La Paz Travel')</title> 
    <!-- Stack para CSS adicional por vista -->
    @stack('styles')
</head>
<body>
    </header>
    <!-- CUERPO PRINCIPAL para la mayoria del contenido de las vistas -->
    <main  >
        <!-- CONTENEDOR principal -->
        <section class="box">
            
            <!-- Sección de contenido principal -->
            @yield('contenedor_formulario')
            
        </section>
    </main>

    <!-- Scripts principales -->
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Stack para scripts adicionales por vista -->
    @stack('scripts')
    
</body>
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    
}

body {
    font-family: Arial;
    background: #f0f2f5;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
a {
    text-decoration: none;  /* Quita el subrayado */
    color: black;           /* Cambia el color (pon el que quieras) */
}
a:hover {
    color: #7c88e3;         /* Cambia el color al pasar el mouse */
}
.box {
    background: white;
    padding: 30px;
    border-radius: 10px;
    width: 400px;
    box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
}

h2 {
    text-align: center;
    font-size: 26px;
}

label {
    display: block;
    margin-top: 10px;
    font-size: 16px;
}

input, select {
    width: 100%;
    padding: 10px;
    margin-top: 5px;
    font-size: 15px;
}

button {
    margin-top: 15px;
    width: 100%;
    padding: 12px;
    background: #2a75e7;
    color: white;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

button:hover {
    background: #1e7e34;
}
</style>
</html>