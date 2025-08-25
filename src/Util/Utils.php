<?php

declare(strict_types=1);

namespace RarusBonus\Util;

final class Utils
{
    public static function snakeToCamel(string $input): string
    {
        $parts = explode('_', $input);
        $camelCase = '';

        foreach ($parts as $part) {
            $camelCase .= ucfirst($part);
        }

        return lcfirst($camelCase);
    }
}
