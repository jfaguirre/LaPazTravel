<?php

namespace App\Services\IconManager;

class NameFormatter
{
    public function format(string $name): string
    {
        $name = str_replace(['-', '_'], ' ', $name);

        $name = preg_replace('/\s+/', ' ', $name);

        return mb_convert_case(
            trim($name),
            MB_CASE_TITLE,
            'UTF-8'
        );
    }
}