<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sitio\SitioControlador;
use App\Http\Controllers\Categoria\CategoriaControlador;
use App\Http\Controllers\Regla\ReglaControlador;
use App\Http\Controllers\Servicio\ServicioControlador;

use Illuminate\Support\Facades\Route;

// Rutas publicas
Route::view('/', 'inicio')->name('inicio');
Route::view('/la-paz-centro', '../paginas/regiones/LaPazCentro')->name('la-paz-centro');
Route::view('/la-paz-este', '../paginas/regiones/LaPazEste')->name('la-paz-este');

// Grupo para rutas protegidas
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    
    // Perfil del usuario
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Registro del perfil del sitio    
    Route::get('/dashboard/sitio', [SitioControlador::class, 'create'])->name('sitio.create');
    Route::post('/dashboard/sitio', [SitioControlador::class, 'store'])->name('sitio.store');

    
    // Registro de Categorías
    Route::get('/dashboard/categoria', [CategoriaControlador::class, 'create'])->name('categoria.create');
    Route::post('/dashboard/categoria', [CategoriaControlador::class, 'store'])->name('categoria.store');

    // Registro de Reglas
    Route::get('/dashboard/regla', [ReglaControlador::class, 'create'])->name('regla.create');
    Route::post('/dashboard/regla', [ReglaControlador::class, 'store'])->name('regla.store');

    // Registro de Servicios
    Route::get('/dashboard/servicio', [ServicioControlador::class, 'create'])->name('servicio.create');
    Route::post('/dashboard/servicio', [ServicioControlador::class, 'store'])->name('servicio.store');

});

require __DIR__.'/auth.php';
