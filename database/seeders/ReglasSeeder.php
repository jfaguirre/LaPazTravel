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

        Regla::create([
            'regla' => 'Fumar',
            'icono' => 'uploads/icons/reglas/1786489916_6a7bac3c5d28c.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Fotografías',
            'icono' => 'uploads/icons/reglas/1786494072_6a7bbc78cf9ee.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Fogatas',
            'icono' => 'uploads/icons/reglas/1786383009_6a7a0aa148e59.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Ventas',
            'icono' => 'uploads/icons/reglas/1786495710_6a7bc2de58a5c.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Ventas ambulantes',
            'icono' => 'uploads/icons/reglas/1786496697_6a7bc6b917c1f.svg',
            'estado' => 'ACTIVO',            
        ]);

        Regla::create([
            'regla' => 'Cortopulsantes',
            'icono' => 'uploads/icons/reglas/1786496446_6a7bc5be215d7.svg',
            'estado' => 'ACTIVO',            
        ]);
    }
}
  