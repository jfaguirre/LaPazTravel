<?php

namespace App\Services\IconManager;

class SvgCleaner
{
    public function clean(string $svg): string
    {
        // Eliminar XML
        $svg = preg_replace('/<\?xml.*?\?>\s*/is', '', $svg);

        // Eliminar DOCTYPE
        $svg = preg_replace('/<!DOCTYPE[^>]*>\s*/is', '', $svg);

        // Eliminar metadata
        $svg = preg_replace('/<metadata>.*?<\/metadata>\s*/is', '', $svg);

        // Eliminar width
        $svg = preg_replace('/\swidth="[^"]*"/i', '', $svg);

        // Eliminar height
        $svg = preg_replace('/\sheight="[^"]*"/i', '', $svg);

        // fill -> currentColor
        $svg = preg_replace(
            '/fill="(?!none)[^"]*"/i',
            'fill="currentColor"',
            $svg
        );

        // stroke -> currentColor
        $svg = preg_replace(
            '/stroke="(?!none)[^"]*"/i',
            'stroke="currentColor"',
            $svg
        );

        // Blade attributes
        $svg = preg_replace(
            '/<svg\b([^>]*)>/i',
            '<svg$1 {{ $attributes }}>',
            $svg,
            1
        );

        return trim($svg);
    }
}