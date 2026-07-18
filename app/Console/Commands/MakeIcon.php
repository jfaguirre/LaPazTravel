<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\IconManager\IconSynchronizer;
use App\Services\IconManager\SvgCleaner;
use App\Services\IconManager\DatabaseRegistrar;
use App\Services\IconManager\NameFormatter;

class MakeIcon extends Command
{
    
    protected IconSynchronizer $synchronizer;

   public function __construct(IconSynchronizer $synchronizer)
   {
        parent::__construct();

        $this->synchronizer = $synchronizer;
    }   
    

    protected $signature = 'icons:import
                        {path : Archivo SVG o carpeta}
                        {--profile= : Perfil de configuración}';

    protected $description = 'Crear un componente Blade desde un SVG';

      
    public function handle(): int
    {
        $path = $this->argument('path');

        if (! File::exists($path)) {

            $this->error("La ruta no existe.");

            return self::FAILURE;
        }

        if (File::isDirectory($path)) {

            return $this->importarCarpeta($path);
        }

        return $this->importarArchivo($path);
    }


    protected function importarArchivo(string $svgPath): int
    {
        $this->info("Importando:");

        $this->line($svgPath);

        try {

            $this->synchronizer->sync(
                $svgPath,
                $this->option('profile')
            );

            $this->info(
                "✔ " . pathinfo(
                    $svgPath,
                    PATHINFO_FILENAME
                )
            );

            return self::SUCCESS;

        } catch (\InvalidArgumentException $e) {

            $this->error($e->getMessage());

            return self::FAILURE;
        }
    }
    



    protected function importarCarpeta(string $folder, ?array $profile = null): int
    {
        $this->info("Buscando SVG...");

        $archivos = File::files($folder);

        $contador = 0;

        foreach ($archivos as $archivo) {

            if ($archivo->getExtension() !== 'svg') {

                continue;

            }

            $this->importarArchivo($archivo->getRealPath(), $profile);

            $contador++;

        }

        $this->newLine();

        $this->info("{$contador} iconos importados.");

        return self::SUCCESS;
    }
    
}