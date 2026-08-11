<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sitio\Sitio\SitioControlador;
use App\Http\Controllers\Sitio\Dashboard\DashboardControlador;
use App\Http\Controllers\Sitio\DashboardSitio\categorias\CategoriasControlador;
use App\Http\Controllers\sitio\dashboardsitio\DashboardSitioControlador;
use App\Http\Controllers\Sitio\DashboardSitio\reglas\ReglasControlador;
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

     // Mostrar sitio con Slug    
    Route::get('/{slug}', [SitioSlugControlador::class, 'show'])->name('sitio.show');

require __DIR__.'/auth.php';
