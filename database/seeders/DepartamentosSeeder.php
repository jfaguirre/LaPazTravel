<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartamentosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::create(['departamento' => 'Ahuachapán', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'Cabañas', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'Chalatenango', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'Cuscatlán', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'La Libertad', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'La Paz', 'estado' => 'ACTIVO', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'La Unión', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'Morazán', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'San Miguel', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'San Salvador', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'San Vicente', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'Santa Ana', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'Sonsonate', 'id_pais' => 1]);
        Departamento::create(['departamento' => 'Usulután', 'id_pais' => 1]);
    }
}
