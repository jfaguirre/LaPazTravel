<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Publicacion;
use App\Models\SitioPerfil;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //permite compartir los datos de los modelos en las vistas
        View::share('sitiosP', SitioPerfil::whereHas('sitio', function ($query) {
            $query->where('estado', 'APROBADO');
        })->with(['sitio', 'distrito', 'departamento', 'municipio', 'precios','categorias','reglas','servicios'])->get());
    }
}
