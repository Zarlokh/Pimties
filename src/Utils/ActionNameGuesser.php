<?php

namespace App\Utils;

class ActionNameGuesser
{
    public static function guessActionName(string $prefix, string $subClassname): string
    {
        return sprintf('%s%s', $prefix, ClassUtils::getOnlyClassSnakeCase($subClassname));
    }
}
