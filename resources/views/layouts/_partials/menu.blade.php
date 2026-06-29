
    <header >
        <h1>logo La Paz Travel</h1>
        <div class ="nav-container">
            <!--boton del menu desplegable -->
            <div class="burgerMenu" id="bm">☰</div>
            <!--  barra de busqueda -->
            <div class="search">
                <input type="text" placeholder="Buscar...">
                <button>🔍</button>
            </div>
            
            <!-- menu que se desplegara al presionar el boton -->
            <nav class = "menu" id="menu">
                <a class="item" href="{{ route('index')}}" ">Inicio</a>
                <a class="item" href="{{ route('about')}}" >Acerca de</a>
                <a class="item" href="{{ route('index')}}" >Contacto</a>
                <a class="item" href="{{ route('formularioPrueba')}}">probar formulario</a>
                <a class="item" href="{{ route('index')}}">ver mapa</a><!-- no funciona aun -->
            </nav>
            
        </div>
    </header>