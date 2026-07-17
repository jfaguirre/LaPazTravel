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
                'email' => 'cchicas@gmail.com',
                'password' => Hash::make('User2026')            
            ]);
            $su->assignRole('su');

        $admin = User::create([
                'name' => 'Juan Francisco',
                'lastName' => 'Aguirre',
                'email' => 'jfaguirre@gmail.com',
                'password' => Hash::make('User2026')            
            ]);
            $admin->assignRole('admin');
    }
}
