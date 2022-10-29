<?php

namespace App\Utils;

use EasyCorp\Bundle\EasyAdminBundle\Dto\FieldDto;

class FieldUtils
{
    public static function addAttrToField(FieldDto $dto, array $newAttr): void
    {
        /** @var array $currentAttr */
        $currentAttr = $dto->getFormTypeOption('attr') ?? [];
        $dto->setFormTypeOption('attr', array_merge($currentAttr, $newAttr));
    }
}
