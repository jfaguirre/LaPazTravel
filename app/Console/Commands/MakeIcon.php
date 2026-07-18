<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\IconManager\SvgCleaner;
use App\Services\IconManager\ProfileResolver;
use App\Services\IconManager\DatabaseRegistrar;

class MakeIcon extends Command
{
    
    protected SvgCleaner $cleaner;
    protected ProfileResolver $profileResolver;
    protected DatabaseRegistrar $databaseRegistrar;

    public function __construct()
    {
         parent::__construct();

        $this->cleaner = new SvgCleaner();
        $this->profileResolver = new ProfileResolver();

        $this->databaseRegistrar = new DatabaseRegistrar();
    }

    protected $signature = 'icons:import
                        {path : Archivo SVG o carpeta}
                        {--profile= : Perfil de configuración}';

    protected $description = 'Crear un componente Blade desde un SVG';
      
    public function handle(): int
    {
        $path = $this->argument('path');

        $profileName = $this->option('profile');

        $profile = null;

        if ($profileName) {
            try {
                $profile = $this->profileResolver->resolve($profileName);
            } catch (\InvalidArgumentException $e) {
                $this->error($e->getMessage());

                return self::FAILURE;
            }
        }

        if (! File::exists($path)) {

            $this->error("La ruta no existe.");

            return self::FAILURE;

        }

        if (File::isDirectory($path)) {

            return $this->importarCarpeta($path, $profile);

        }

        return $this->importarArchivo($path, $profile);
    }


    protected function importarArchivo(string $svgPath, ?array $profile = null): int
    {
        
        $this->info("Importando:");

        $this->line($svgPath);

        $nombre = pathinfo($svgPath, PATHINFO_FILENAME);

        $contenido = File::get($svgPath);

        
        $contenido = $this->cleaner->clean($contenido);
        

        $destino = resource_path(
            "views/components/icons/{$nombre}.blade.php"
        );

        File::ensureDirectoryExists(dirname($destino));

        if (File::exists($destino)) {

            if (!$this->confirm("{$nombre} ya existe. ¿Sobrescribir?")) {

                $this->warn("Omitido.");

                return self::SUCCESS;

            }

        }

        File::put($destino, $contenido);

        if ($profile) {

            $this->databaseRegistrar->register(
                $profile,
                $nombre,
                $nombre
            );

        }

        $this->info("✔ {$nombre}");

        return self::SUCCESS;

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