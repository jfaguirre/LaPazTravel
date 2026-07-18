<?php

namespace App\Services\IconManager;

use Illuminate\Support\Facades\File;

class IconSynchronizer
{
    public function __construct(
        protected SvgCleaner $cleaner,
        protected NameFormatter $nameFormatter,
        protected ProfileResolver $profileResolver,
        protected DatabaseRegistrar $databaseRegistrar,
        protected BladeGenerator $bladeGenerator
    ) {
    }

    public function sync(
        string $svgPath,
        ?string $profileName = null
    ): array {

        $nombreIcono = pathinfo(
            $svgPath,
            PATHINFO_FILENAME
        );

        $nombre = $this->nameFormatter->format(
            $nombreIcono
        );

        $contenido = File::get($svgPath);

        $contenido = $this->cleaner->clean(
            $contenido
        );

        $profile = null;

        if ($profileName) {

            $profile = $this->profileResolver->resolve(
                $profileName
            );
        }

        $bladeExists = $this->bladeGenerator->generate(
            $nombreIcono,
            $contenido
        );

        $databaseExists = null;

        if ($profile) {

            $databaseExists =
                ! $this->databaseRegistrar->registerIfNotExists(
                    $profile,
                    $nombre,
                    $nombreIcono
                );
        }

        return [

            'name' => $nombre,

            'icon' => $nombreIcono,

            'blade_exists' => $bladeExists,

            'database_exists' => $databaseExists,

        ];
    }
}