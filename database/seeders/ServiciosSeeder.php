<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiciosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Servicio::create([
            'servicio' => 'Parqueo',
            'icono' => 'uploads/icons/servicios/1784514835_6a5d8913cb210.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Ciclismo',
            'icono' => 'uploads/icons/servicios/1786506393_6a7bec99733e5.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Piscinas',
            'icono' => 'uploads/icons/servicios/1786506480_6a7becf0c9c3e.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Sombrillas',
            'icono' => 'uploads/icons/servicios/1786506600_6a7bed682ac14.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Paseo en caballo',
            'icono' => 'uploads/icons/servicios/1786506783_6a7bee1f06afc.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Juegos infantiles',
            'icono' => 'uploads/icons/servicios/1786506952_6a7beec81bcb7.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Cancha de Basketball',
            'icono' => 'uploads/icons/servicios/1786507202_6a7befc2e5ad5.svg',
            'estado' => 'ACTIVO'
        ]);        

        Servicio::create([
            'servicio' => 'Cancha de Football',
            'icono' => 'uploads/icons/servicios/1786507378_6a7bf072c5b30.svg',
            'estado' => 'ACTIVO'
        ]); 

        Servicio::create([
            'servicio' => 'Cancha de Volleyball',
            'icono' => 'uploads/icons/servicios/1786507886_6a7bf26e2155d.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Restaurante',
            'icono' => 'uploads/icons/servicios/1786508046_6a7bf30e8d89f.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Cafetería',
            'icono' => 'uploads/icons/servicios/1786508342_6a7bf436f3517.svg',
            'estado' => 'ACTIVO'
        ]);

        Servicio::create([
            'servicio' => 'Hospedaje',
            'icono' => 'uploads/icons/servicios/1786509559_6a7bf8f7e93a9.svg',
            'estado' => 'ACTIVO'
        ]);

         

    }
}
