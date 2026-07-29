<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Categoria::create([
            'nombre' => 'Campamento',
            'icono' => 'uploads/icons/categorias/1784514672_6a5d887078027.svg',
            'estado' => 'ACTIVO',
            'color' => '#F54927'
        ]);
    }
}
