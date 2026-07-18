<?php

namespace App\Services\IconManager;

use Illuminate\Support\Facades\File;

class BladeGenerator
{
    public function generate(
        string $iconName,
        string $content
    ): void {
        $destination = resource_path(
            "views/components/icons/{$iconName}.blade.php"
        );

        File::ensureDirectoryExists(
            dirname($destination)
        );

        File::put(
            $destination,
            $content
        );
    }
}