<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Sitio\SitioControlador;
use Illuminate\Support\Facades\Route;

// Rutas publicas
Route::view('/', 'inicio')->name('inicio');


// Grupo para rutas protegidas
Route::middleware(['auth', 'verified'])->group(function () {

    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Regristro del perfil del sitio    
    Route::get('/dashboard/sitio', [SitioControlador::class, 'create'])->name('sitio.create');

});

require __DIR__.'/auth.php';
