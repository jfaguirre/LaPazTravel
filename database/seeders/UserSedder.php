<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $su = User::create([
                'name' => 'Caleb',
                'lastName' => 'Chicas',
                'telefono' => '72210102',
                'email' => 'cchicas@gmail.com',
                'password' => Hash::make('User2026')            
            ]);
            $su->assignRole('su');

        $admin = User::create([
                'name' => 'Juan Francisco',
                'lastName' => 'Aguirre',
                'telefono' => '76340101',
                'email' => 'jfaguirre@gmail.com',
                'password' => Hash::make('User2026')            
            ]);
            $admin->assignRole('admin');

        $admin = User::create([
                'name' => 'Evelin Carolina',
                'lastName' => 'Vasquez Umaña',
                'telefono' => '78301215',
                'email' => 'ecvasquez@gmail.com',
                'password' => Hash::make('User2026')            
            ]);
            $admin->assignRole('admin');
    }
}
