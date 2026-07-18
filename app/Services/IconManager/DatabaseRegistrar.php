<?php

namespace App\Services\IconManager;

use Illuminate\Support\Facades\DB;

class DatabaseRegistrar
{
    public function register(array $profile, string $name, string $icon): bool
    {
        $table = $profile['table'];

        $nameColumn = $profile['name_column'];

        $iconColumn = $profile['icon_column'];

        $exists = DB::table($table)
            ->where($nameColumn, $name)
            ->orWhere($iconColumn, $icon)
            ->exists();

        if ($exists) {
            return false;
        }

        $data = $profile['defaults'];

        $data[$nameColumn] = $name;

        $data[$iconColumn] = $icon;

        DB::table($table)->insert($data);

        return true;
    }
}