
        <h1>logo La Paz Travel</h1>
        <div class ="nav-container navbar navbar-expand-lg">
            <!--boton del menu desplegable -->
            <div class="burgerMenu" id="bm">☰</div>

            <!--  barra de busqueda -->
            <div class="search">
                <input type="text" placeholder="Buscar...">
                <button>🔍</button>
            </div>
            <!-- <a class="boton" href="#">publicar un sitio</a>-->
            @auth 
                <a class="btnLogin" href="{{ route('dashboard')}}">ir al dashboard</a>
            @else
                <a class="btnLogin" href="{{ route('login') }}">Log in</a>           
            @endauth
            

            <!-- menu que se desplegara al presionar el boton -->
            <nav class = "menu" id="menu">
                <a class="item" href="{{ route('inicio')}}">Inicio</a>                          
            </nav>
            


        </div>