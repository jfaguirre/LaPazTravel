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
    }
}
