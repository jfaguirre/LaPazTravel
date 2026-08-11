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

        Categoria::create([
            'nombre' => 'Parque',
            'icono' => 'uploads/icons/categorias/1786382433_6a7a086148996.svg',
            'estado' => 'ACTIVO',
            'color' => '#F54927'
        ]);

        Categoria::create([
            'nombre' => 'Playa',
            'icono' => 'uploads/icons/categorias/1786382756_6a7a09a461b89.svg',
            'estado' => 'ACTIVO',
            'color' => '#0F52BA'
        ]);

        Categoria::create([
            'nombre' => 'Fogata',
            'icono' => 'uploads/icons/categorias/1786383009_6a7a0aa148e59.svg',
            'estado' => 'ACTIVO',
            'color' => '#0F52BA'
        ]);

        Categoria::create([
            'nombre' => 'Montaña',
            'icono' => 'uploads/icons/categorias/1786410650_6a7a769aa78a6.svg',
            'estado' => 'ACTIVO',
            'color' => '#F54927'
        ]);        

        Categoria::create([
            'nombre' => 'Naturaleza',
            'icono' => 'uploads/icons/categorias/1786413271_6a7a80d737966.svg',
            'estado' => 'ACTIVO',
            'color' => '#00b344'
        ]);        

        Categoria::create([
            'nombre' => 'Bosque',
            'icono' => 'uploads/icons/categorias/1786413931_6a7a836b1ae91.svg',
            'estado' => 'ACTIVO',
            'color' => '#00b344'
        ]);

        Categoria::create([
            'nombre' => 'Zoológico',
            'icono' => 'uploads/icons/categorias/1786414204_6a7a847c8f2f5.svg',
            'estado' => 'ACTIVO',
            'color' => '#F54927'
        ]);
        
    }
}
