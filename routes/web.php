<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sitio\Sitio\SitioControlador;
use App\Http\Controllers\Sitio\Dashboard\DashboardControlador;
use App\Http\Controllers\Super\Dashboard\SuDashboardController;
use App\Http\Controllers\Super\SuController;
use App\Http\Controllers\Super\Usuario\SuUsuarioController;
use App\Http\Controllers\Sitio\DashboardSitio\categorias\CategoriasControlador;
use App\Http\Controllers\sitio\dashboardsitio\DashboardSitioControlador;
use App\Http\Controllers\sitio\dashboardsitio\gps\GpsControlador;
use App\Http\Controllers\sitio\dashboardsitio\informacion\InformacionControlador;
use App\Http\Controllers\sitio\dashboardsitio\horarios\HorarioControlador;
use App\Http\Controllers\sitio\dashboardsitio\precios\PrecioControlador;
use App\Http\Controllers\sitio\dashboardsitio\portada\PortadaControlador;
use App\Http\Controllers\Sitio\DashboardSitio\reglas\ReglasControlador;
use App\Http\Controllers\Sitio\DashboardSitio\servicios\ServiciosControlador;
use App\Http\Controllers\sitio\dashboardsitio\ubicacion\UbicacionControlador;
use App\Http\Controllers\Sitio\Perfil\PerfilSitioControlador;
use App\Http\Controllers\Sitio\Sitio\SitioSlugControlador;
use App\Http\Controllers\Super\Sitio\Categoria\CategoriaControlador;
use App\Http\Controllers\Super\Sitio\Regla\ReglaControlador;
use App\Http\Controllers\Super\Sitio\Servicio\ServicioControlador;
use App\Http\Controllers\Super\Solicitud\SolicitudControlador;

use Illuminate\Support\Facades\Route;

// Rutas publicas
Route::view('/', 'inicio')->name('inicio');
Route::view('/lapaz/centro', 'paginas.regiones.LaPazCentro')->name('la-paz-centro');
Route::view('/lapaz/este', 'paginas.regiones.LaPazEste')->name('la-paz-este');

    // Grupo para rutas protegidas
    Route::middleware(['auth', 'verified'])->group(function () {

        Route::middleware(['acceso.sitio'])->group(function () {
            Route::get('/dashboard/sitio/create', [SitioControlador::class, 'create'])->name('sitio.create');
            Route::post('/dashboard/sitio/create', [SitioControlador::class, 'store'])->name('sitio.store');
            Route::get('/dashboard/sitio/edit', [SitioControlador::class, 'edit'])->name('sitio.edit');
            Route::put('/dashboard/sitio/update', [SitioControlador::class, 'update'])->name('sitio.update');

            // Rutas del Perfil del Sitio (Categorías, Reglas, Servicios y ubicacion para el sitio del Usuario)
            Route::get('/dashboard/perfil/ubicacion/agregar', [PerfilSitioControlador::class, 'ubicacion_sitio'])->name('perfil.ubicacion.agregar');
            Route::post('/dashboard/perfil/ubicacion/store', [PerfilSitioControlador::class, 'guardar_ubicacion'])->name('perfil.ubicacion.store');

            Route::get('/dashboard/perfil/categoria', [PerfilSitioControlador::class, 'agregarCategoria'])->name('perfil.categoria.agregar');
            Route::post('/dashboard/perfil/categoria', [PerfilSitioControlador::class, 'guardarCategoria'])->name('perfil.categoria.guardar');

            Route::get('/dashboard/perfil/regla', [PerfilSitioControlador::class, 'agregarRegla'])->name('perfil.regla.agregar');
            Route::post('/dashboard/perfil/regla', [PerfilSitioControlador::class, 'guardarRegla'])->name('perfil.regla.guardar');

            Route::get('/dashboard/perfil/servicio', [PerfilSitioControlador::class, 'agregarServicio'])->name('perfil.servicio.agregar');
            Route::post('/dashboard/perfil/servicio', [PerfilSitioControlador::class, 'guardarServicio'])->name('perfil.servicio.guardar');
        });

        Route::middleware(['dashboardSitio'])->group(function () {
        
            Route::get('/dashboard/sitio/panel', [DashboardSitioControlador::class, 'inicio'])->name('dashboard.sitio.inicio');
            // CRUD Ubicacion
            Route::get('dashboard/sitio/ubicacion/inicio', [UbicacionControlador::class, 'index'])->name('ubicacion.inicio');
            Route::put('dashboard/sitio/ubicacion/update', [UbicacionControlador::class, 'update'])->name('ubicacion.update');

            // CRUD Categoria
            Route::get('dashboard/sitio/categoria/inicio', [CategoriasControlador::class, 'inicio'])->name('categoria.inicio');
            Route::put('dashboard/sitio/categoria/update', [CategoriasControlador::class, 'update'])->name('categoria.update');

            // CRUD Reglas
            Route::get('dashboard/sitio/regla/inicio', [ReglasControlador::class, 'inicio'])->name('regla.inicio');
            Route::put('dashboard/sitio/regla/update', [ReglasControlador::class, 'update'])->name('regla.update');

            // CRUD Servicios
            Route::get('dashboard/sitio/servicio/inicio', [ServiciosControlador::class, 'inicio'])->name('servicio.inicio');
            Route::put('dashboard/sitio/servicio/update', [ServiciosControlador::class, 'update'])->name('servicio.update');

            // CRUD Informacion
            Route::get('dashboard/sitio/informacion/inicio', [InformacionControlador::class, 'inicio'])->name('informacion.inicio');
            Route::put('dashboard/sitio/informacion/update', [InformacionControlador::class, 'update'])->name('informacion.update');

            // CRUD GPS
            Route::get('dashboard/sitio/gps/inicio', [GpsControlador::class, 'inicio'])->name('gps.inicio');
            Route::put('dashboard/sitio/gps/update', [GpsControlador::class, 'update'])->name('gps.update');

            // CRUD Horarios
            Route::get('dashboard/sitio/horario/inicio', [HorarioControlador::class, 'inicio'])->name('horario.inicio');
            Route::put('dashboard/sitio/horario/update', [HorarioControlador::class, 'update'])->name('horario.update');

            // CRUD Precios
            Route::get('dashboard/sitio/precio/inicio', [PrecioControlador::class, 'inicio'])->name('precio.inicio');
            Route::put('dashboard/sitio/precio/update', [PrecioControlador::class, 'update'])->name('precio.update');

            // CRUD Portada            
            Route::put('dashboard/sitio/portada/update', [PortadaControlador::class, 'update'])->name('portada.update');

        });

        // Dahsboard
        Route::get('/dashboard', [DashboardControlador::class, 'dashboard'])->name('dashboard');

        // Perfil del usuario
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        // Iniciar datos del perfil minimos
        Route::get('dashboard/perfil/inicio', [PerfilSitioControlador::class, 'inicio'])->name('perfil.inicio');
        Route::get('dashboard/perfil/create', [PerfilSitioControlador::class, 'perfilSitio'])->name('perfil.create');        
        

        Route::middleware(['role:su'])->prefix('super')->name('super.')->group(function () {

            Route::get('/dashboard', [SuDashboardController::class, 'dashboard'])->name('dashboard');

            Route::get('/get-municipios/{departamentoId}', [SuController::class, 'getMunicipios'])->name('getMunicipios');
            Route::get('/get-distritos/{municipioId}', [SuController::class, 'getDistritos'])->name('getDistritos');

            Route::get('/sitio', [SuController::class, 'sitioIndex'])->name('sitio.index');

            // Pantalla de revisión individual
            Route::get('/sitio/{id}/revisar', [SuController::class, 'revisar'])->name('sitio.revisar');
            
            // Acciones para cambiar el estado de la solicitud
            Route::patch('/sitio/{id}/aprobar', [SuController::class, 'aprobar'])->name('sitio.aprobar');
            Route::patch('/sitio/{id}/rechazar', [SuController::class, 'rechazar'])->name('sitio.rechazar');
            Route::patch('/sitio/{id}/suspender', [SuController::class, 'suspender'])->name('sitio.suspender');
            Route::patch('/sitio/{id}/pendiente', [SuController::class, 'pendiente'])->name('sitio.pendiente');

            Route::resource('usuario', SuUsuarioController::class);
    
        });
        Route::get('dashboard/perfil/create', [PerfilSitioControlador::class, 'perfilSitio'])->name('perfil.create');
        Route::post('dashboard/perfil/create', [PerfilSitioControlador::class, 'perfil_session'])->name('perfil.session');

        // Registro de Categorías (Admin o Configuración General)
        Route::get('/dashboard/sitio/categoria', [CategoriaControlador::class, 'create'])->name('categoria.create');
        Route::post('/dashboard/sitio/categoria', [CategoriaControlador::class, 'store'])->name('categoria.store');

        // Registro de Reglas (Admin o Configuración General)
        Route::get('/dashboard/regla/create', [ReglaControlador::class, 'create'])->name('regla.create');
        Route::post('/dashboard/regla/create', [ReglaControlador::class, 'store'])->name('regla.store');

        // Registro de Servicios (Admin o Configuración General)
        Route::get('/dashboard/servicio/create', [ServicioControlador::class, 'create'])->name('servicio.create');
        Route::post('/dashboard/servicio/create', [ServicioControlador::class, 'store'])->name('servicio.store');

        // Aprobación de Solicitudes (Super Admin)
        Route::get('/super/solicitudes', [SolicitudControlador::class, 'index'])->name('super.solicitudes.index');
        Route::get('/super/solicitudes/{id}', [SolicitudControlador::class, 'show'])->name('super.solicitudes.show');
        Route::post('/super/solicitudes/{id}/aprobar', [SolicitudControlador::class, 'aprobar'])->name('super.solicitudes.aprobar');
        Route::post('/super/solicitudes/{id}/rechazar', [SolicitudControlador::class, 'rechazar'])->name('super.solicitudes.rechazar');   
    });

    require __DIR__.'/auth.php';
    
     // Mostrar sitio con Slug    
    Route::get('/{slug}', [SitioSlugControlador::class, 'show'])->name('sitio.show');


