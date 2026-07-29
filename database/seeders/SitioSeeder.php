<?php

namespace Database\Seeders;

use App\Models\Sitio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SitioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Sitio::create([
            'nombre' => 'Mango Village',
            'slug' => 'mango-village',
            'descripcion_corta' => 'Un lugar natural para disfrutar en familia.',
            'estado' => 'PENDIENTE',
            'id_user' => 2
        ]);

        Sitio::create([
            'nombre' => 'Juanitos',
            'slug' => 'juanitos',
            'descripcion_corta' => 'Tasty and traditional gourmet.',
            'estado' => 'PENDIENTE',
            'id_user' => 3
        ]);
    }
}
