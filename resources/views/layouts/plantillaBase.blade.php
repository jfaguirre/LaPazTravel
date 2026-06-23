<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Título dinámico con valor por defecto -->
    <title>@yield('titulo', 'La Paz Travel')</title>
    <!-- Stack para CSS adicional por vista -->
    @stack('styles')
</head>
<body>
    <!-- NAVBAR -->
    <header >
        <div >
            <h1>logo La Paz Travel</h1>
            <nav>
                <a href="/" ">Inicio</a>
                <a href="/about" >Acerca de</a>
                <a href="/contact" >Contacto</a>
            </nav>
        </div>
    </header>
    <!-- CUERPO PRINCIPAL para la mayoria del contenido de las vistas -->
    <main >
        <!-- CONTENEDOR principal -->
        <section>
            
            <!-- Sección de contenido principal -->
            @yield('contenedor_principal')
            
        </section>
    </main>
    <!-- FOOTER (común a todas las vistas)         -->
    <footer >
        <p>&copy; {{ date('Y') }} La Paz Travel. Todos los derechos reservados.</p>
    </footer>
    
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
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #007BFF;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    transition: all 0.3s ease;
}

/* Header */
header {
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    padding: 1rem 2rem;
}

header h1 {
    color: #333;
    text-align: center;
    margin-bottom: 1rem;
    font-size: 1.8rem;
}

/* Navegación principal */
nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

nav a {
    color: #031b35;
    text-decoration: none;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border-radius: 4px;
    transition: background 0.3s, color 0.3s;
}
nav a:hover {
    background: #031b35;
    color: white;
}
.boton {
    background: #089ab4;
    color: white;
    transition: all 0.3s ease;
    text-decoration: none;
    border-radius: 4px;
    padding: 0.5rem 0.5rem;
}
.boton:hover {
    background: #0850b4;
    color: white;
    transform: translateY(-2px);
}
main {
    flex: 1;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f0f2f5;
    padding: 2rem;
}
</style>
</html>