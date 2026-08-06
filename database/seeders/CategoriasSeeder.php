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

        Categoria::create([
            'nombre' => 'Balneario',
            'icono' => 'uploads/icons/categorias/1785788560_6a70f890b30b8.svg',
            'estado' => 'ACTIVO',
            'color' => '#0F52BA'
        ]);

        Categoria::create([
            'nombre' => 'Mirador',
            'icono' => 'uploads/icons/categorias/1785789513_6a70fc49af830.svg',
            'estado' => 'ACTIVO',
            'color' => '#F54927'
        ]);

         Categoria::create([
            'nombre' => 'Senderismo',
            'icono' => 'uploads/icons/categorias/1785790115_6a70fea3f1544.svg',
            'estado' => 'ACTIVO',
            'color' => '#F54927'
        ]);
    }
}
