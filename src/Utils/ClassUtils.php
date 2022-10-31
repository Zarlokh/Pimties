<?php

namespace App\Utils;

use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;

class ClassUtils
{
    public static function getOnlyClassSnakeCase(string $classname): string
    {
        return (new CamelCaseToSnakeCaseNameConverter())->normalize(substr(strrchr($classname, '\\'), 1));
    }
}
