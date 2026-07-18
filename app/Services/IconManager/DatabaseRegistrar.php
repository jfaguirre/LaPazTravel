<?php

namespace App\Services\IconManager;

use Illuminate\Support\Facades\DB;

class DatabaseRegistrar
{
    public function register(
        array $profile,
        string $name,
        string $icon
    ): void {
        $data = $profile['defaults'];

        $data[$profile['name_column']] = $name;
        $data[$profile['icon_column']] = $icon;

        DB::table($profile['table'])->insert($data);
    }
}