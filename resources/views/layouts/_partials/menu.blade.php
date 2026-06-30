
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
                <a class="item" href="{{ route('inicio')}}">Inicio</a>                           
            </nav>
            @auth
                <a class="btnLogin" href="{{ route('logout') }}">Log out</a> 
            @else
                <a class="btnLogin" href="{{ route('login') }}">Log in</a>           
            @endauth


        </div>
   