<?php

namespace Database\Seeders;

use App\Models\Regla;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReglasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Regla::create([
            'regla' => 'Alimentos',
            'icono' => 'uploads/icons/reglas/1784514766_6a5d88ceb0c25.svg',
            'estado' => 'ACTIVO'
        ]);
    }
}
  