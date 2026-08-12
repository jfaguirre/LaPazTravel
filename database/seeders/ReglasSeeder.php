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
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Bebidas',
            'icono' => 'uploads/icons/reglas/1786421796_6a7aa22489066.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Mascotas',
            'icono' => 'uploads/icons/reglas/1786422309_6a7aa4257be61.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Arma de fuego',
            'icono' => 'uploads/icons/reglas/1786422704_6a7aa5b096de8.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Tirar basuca',
            'icono' => 'uploads/icons/reglas/1786423124_6a7aa7544fbc2.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Hamacas',
            'icono' => 'uploads/icons/reglas/1786424389_6a7aac451524c.svg',
            'estado' => 'ACTIVO',            
        ]);


        
    }
}
  