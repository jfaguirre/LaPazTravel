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
    ): bool {
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

        $this->bladeGenerator->generate(
            $nombreIcono,
            $contenido
        );
       
        if ($profile) {

            $this->databaseRegistrar->register(
                $profile,
                $nombre,
                $nombreIcono
            );

        }

        return true;
    }
}