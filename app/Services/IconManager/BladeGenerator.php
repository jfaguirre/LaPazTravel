<?php

namespace App\Services\IconManager;

use Illuminate\Support\Facades\File;

class BladeGenerator
{
    public function generate(
        string $iconName,
        string $content
    ): bool {

        $destination = resource_path(
            "views/components/icons/{$iconName}.blade.php"
        );

        $exists = File::exists($destination);

        File::ensureDirectoryExists(
            dirname($destination)
        );

        File::put(
            $destination,
            $content
        );

        return $exists;
    }
}