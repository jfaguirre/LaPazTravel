<?php

namespace App\Services\IconManager;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseRegistrar
{
    public function registerIfNotExists(
        array $profile,
        string $name,
        string $icon
    ): bool {

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

        if (
            Schema::hasColumn($table, 'created_at')
        ) {
            $data['created_at'] = now();
            }

        if (
            Schema::hasColumn($table, 'updated_at')
        ) {
            $data['updated_at'] = now();
        }

        DB::table($table)->insert($data);

        return true;
    }
}