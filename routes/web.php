<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () 
{return view('inicio');
})->name('index');

Route::get('/formulario', function () {
    return view('paginas.formularioPrueba');
})->name('formulario');

Route::get('/mapa', function () {
    return view('paginas.mapa');
})->name('mapa');

//para la vistas publicas
//retornar a la vista del formulario de prueba
Route::get('/formulario', function () {
    return view('paginas\formularioPrueba');
})->name('formularioPrueba');
// retornar a la vista de mapa
Route::get('/mapa', function () {
    return view('paginas\mapa');
})->name('mapa');

Route::get('/acercaDe', function () {
    return view('paginas\nosotros');
})->name('about');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
