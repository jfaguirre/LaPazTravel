<?php

namespace App\Services\IconManager;

use InvalidArgumentException;

class ProfileResolver
{
    public function resolve(string $profile): array
    {
        $profiles = config('icons.profiles', []);

        if (!array_key_exists($profile, $profiles)) {
            throw new InvalidArgumentException(
                "El perfil '{$profile}' no existe."
            );
        }

        return $profiles[$profile];
    }
}