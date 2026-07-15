<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sitio\SitioControlador;
use App\Http\Controllers\Categoria\CategoriaControlador;
use App\Http\Controllers\Regla\ReglaControlador;
use App\Http\Controllers\Servicio\ServicioControlador;
use Illuminate\Support\Facades\Route;

// Rutas publicas
Route::view('/', 'inicio')->name('inicio');


// Grupo para rutas protegidas
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Verificar si existe el Sitio del usuario
        $sitio = \App\Models\Sitio::where('id_user', $user->id)->first();
        $hasSitio = $sitio !== null;
        
        // Verificar si el SitioPerfil tiene categorias, reglas y servicios asociados
        $hasCategoria = false;
        $hasRegla = false;
        $hasServicio = false;
        
        if ($hasSitio) {
            $perfil = $sitio->perfil;
            if ($perfil) {
                $hasCategoria = $perfil->categorias()->exists();
                $hasRegla = $perfil->reglas()->exists();
                $hasServicio = $perfil->servicios()->exists();
            }
        }
        
        // Calcular porcentaje de avance
        $totalSteps = 4;
        $completedSteps = 0;
        if ($hasSitio) $completedSteps++;
        if ($hasCategoria) $completedSteps++;
        if ($hasRegla) $completedSteps++;
        if ($hasServicio) $completedSteps++;
        
        $percentage = ($completedSteps / $totalSteps) * 100;
        
        return view('dashboard', compact('hasSitio', 'hasCategoria', 'hasRegla', 'hasServicio', 'percentage'));
    })->name('dashboard');

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
