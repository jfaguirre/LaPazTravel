<?php

namespace Database\Seeders;

use App\Models\Municipio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Departamento de Ahuachapan
        Municipio::create([
            'municipio' => 'Ahuachapán Norte',
            'id_departamento' => 1
        ]);

        Municipio::create([
            'municipio' => 'Ahuachapán Centro',
            'id_departamento' => 1
        ]);

        Municipio::create([
            'municipio' => 'Ahuachapán Sur',
            'id_departamento' => 1
        ]);

        // Departamento de Cabañas
        Municipio::create([
            'municipio' => 'Cabañas Este',
            'id_departamento' => 2
        ]);

        Municipio::create([
            'municipio' => 'Cabañas Oeste',
            'id_departamento' => 2
        ]);

        // Departamento de Chalatenango
        Municipio::create([
            'municipio' => 'Chalatenango Norte',
            'id_departamento' => 3
        ]);

        Municipio::create([
            'municipio' => 'Chalatenango Centro',
            'id_departamento' => 3
        ]);

        Municipio::create([
            'municipio' => 'Chalatenango Sur',
            'id_departamento' => 3
        ]);

        // Departamento de Cuscatlán
        Municipio::create([
            'municipio' => 'Cuscatlán Norte',
            'id_departamento' => 4
        ]);

        Municipio::create([
            'municipio' => 'Cuscatlán Sur',
            'id_departamento' => 4
        ]);

        // Departamento de La Libertad
        Municipio::create([
            'municipio' => 'La Libertad Norte',
            'id_departamento' => 5
        ]);

        Municipio::create([
            'municipio' => 'La Libertad Centro',
            'id_departamento' => 5
        ]);

        Municipio::create([
            'municipio' => 'La Libertad Oeste',
            'id_departamento' => 5
        ]);

        Municipio::create([
            'municipio' => 'La Libertad Este',
            'id_departamento' => 5
        ]);

        Municipio::create([
            'municipio' => 'La Libertad Costa',
            'id_departamento' => 5
        ]);

        Municipio::create([
            'municipio' => 'La Libertad Sur',
            'id_departamento' => 5
        ]);

        // Departamento de La Paz
        Municipio::create([
            'municipio' => 'La Paz Oeste',
            'estado' => 'ACTIVO',
            'id_departamento' => 6
        ]);

        Municipio::create([
            'municipio' => 'La Paz Centro',
            'estado' => 'ACTIVO',
            'id_departamento' => 6
        ]);

        Municipio::create([
            'municipio' => 'La Paz Este',
            'estado' => 'ACTIVO',
            'id_departamento' => 6
        ]);

        // Departamento de La Unión
        Municipio::create([
            'municipio' => 'La Unión Norte',
            'id_departamento' => 7
        ]);

        Municipio::create([
            'municipio' => 'La Unión Sur',
            'id_departamento' => 7
        ]);

        // Departamento de Morazán
        Municipio::create([
            'municipio' => 'Morazán Norte',
            'id_departamento' => 8
        ]);

        Municipio::create([
            'municipio' => 'Morazán Sur',
            'id_departamento' => 8
        ]);

        // Departamento de San Miguel
        Municipio::create([
            'municipio' => 'San Miguel Norte',
            'id_departamento' => 9
        ]);

        Municipio::create([
            'municipio' => 'San Miguel Centro',
            'id_departamento' => 9
        ]);

        Municipio::create([
            'municipio' => 'San Miguel Oeste',
            'id_departamento' => 9
        ]);

        // Departamento de San Salvador
        Municipio::create([
            'municipio' => 'San Salvador Norte',
            'id_departamento' => 10
        ]);

        Municipio::create([
            'municipio' => 'San Salvador Oeste',
            'id_departamento' => 10
        ]);

        Municipio::create([
            'municipio' => 'San Salvador Este',
            'id_departamento' => 10
        ]);

        Municipio::create([
            'municipio' => 'San Salvador Centro',
            'id_departamento' => 10
        ]);

        Municipio::create([
            'municipio' => 'San Salvador Sur',
            'id_departamento' => 10
        ]);

        // Departamento de San Vicente
        Municipio::create([
            'municipio' => 'San Vicente Norte',
            'id_departamento' => 11
        ]);

        Municipio::create([
            'municipio' => 'San Vicente Sur',
            'id_departamento' => 11
        ]);

        // Departamento de Santa Ana
        Municipio::create([
            'municipio' => 'San Ana Norte',
            'id_departamento' => 12
        ]);

        Municipio::create([
            'municipio' => 'San Ana Centro',
            'id_departamento' => 12
        ]);

        Municipio::create([
            'municipio' => 'San Ana Este',
            'id_departamento' => 12
        ]);

        Municipio::create([
            'municipio' => 'San Ana Oeste',
            'id_departamento' => 12
        ]);

        // Departamento de Sonsonate
        Municipio::create([
            'municipio' => 'Sonsonate Norte',
            'id_departamento' => 13
        ]);

        Municipio::create([
            'municipio' => 'Sonsonate Centro',
            'id_departamento' => 13
        ]);

        Municipio::create([
            'municipio' => 'Sonsonate Este',
            'id_departamento' => 13
        ]);

        Municipio::create([
            'municipio' => 'Sonsonate Oeste',
            'id_departamento' => 13
        ]);

        // Departamento de Usulután
        Municipio::create([
            'municipio' => 'Usulután Norte',
            'id_departamento' => 14
        ]);

        Municipio::create([
            'municipio' => 'Usulután Este',
            'id_departamento' => 14
        ]);

        Municipio::create([
            'municipio' => 'Usulután Oeste',
            'id_departamento' => 14
        ]);


    }
}
