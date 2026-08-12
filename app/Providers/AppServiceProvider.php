<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Publicacion;
use App\Models\SitioPerfil;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;

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
        // Evita consultar las tablas antes de que existan
        if (Schema::hasTable('sitio_perfil') && Schema::hasTable('sitios')) {
            
            // Permite compartir los datos de los sitios aprobados en las vistas
            View::share(
                'sitiosP',
                SitioPerfil::whereHas('sitio', function ($query) {
                    $query->where('estado', 'APROBADO');
                })
                ->with([
                    'sitio',
                    'distrito',
                    'departamento',
                    'municipio',
                    'precios',
                    'categorias',
                    'reglas',
                    'servicios'
                ])
                ->get()
            );
        } else {
            // Evita errores durante migrate:fresh / migrate:refresh
            View::share('sitiosP', collect());
        }
    }
}