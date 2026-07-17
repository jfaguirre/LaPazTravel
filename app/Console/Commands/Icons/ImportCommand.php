<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Services\IconManager\SvgCleaner;

class MakeIcon extends Command
{
    /**
     * php artisan make:icon volcan resources/icons/volcan.svg
     */
    protected $signature = 'icon:import
                        {path : Archivo SVG o carpeta}';

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

        $nombre = pathinfo($svgPath, PATHINFO_FILENAME);

        $contenido = File::get($svgPath);

        
        $cleaner = new SvgCleaner();
        $contenido = $cleaner->clean($contenido);


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

        $this->info("✔ {$nombre}");

        return self::SUCCESS;
    }

    protected function importarCarpeta(string $folder): int
    {
        $this->info("Buscando SVG...");

        $archivos = File::files($folder);

        $contador = 0;

        foreach ($archivos as $archivo) {

            if ($archivo->getExtension() !== 'svg') {

                continue;

            }

            $this->importarArchivo($archivo->getRealPath());

            $contador++;

        }

        $this->newLine();

        $this->info("{$contador} iconos importados.");

        return self::SUCCESS;
    }

    protected function procesarSvg(string $svg): string
{

    // Eliminar metadata
    $svg = preg_replace('/<metadata>.*?<\/metadata>\s*/is', '', $svg);

    // Eliminar declaración XML
    $svg = preg_replace('/<\?xml.*?\?>\s*/is', '', $svg);

    // Eliminar DOCTYPE
    $svg = preg_replace('/<!DOCTYPE[^>]*>\s*/is', '', $svg);

    // Eliminar width
    $svg = preg_replace('/\swidth="[^"]*"/i', '', $svg);

    // Eliminar height
    $svg = preg_replace('/\sheight="[^"]*"/i', '', $svg);

    // Reemplazar fill
    $svg = preg_replace(
        '/fill="(?!none)[^"]*"/i',
        'fill="currentColor"',
        $svg
    );

    // Reemplazar stroke
    $svg = preg_replace(
        '/stroke="(?!none)[^"]*"/i',
        'stroke="currentColor"',
        $svg
    );

    // Agregar atributos Blade
    $svg = preg_replace(
        '/<svg\b([^>]*)>/i',
        '<svg$1 {{ $attributes }}>',
        $svg,
        1
    );

    return $svg;
}


    
}