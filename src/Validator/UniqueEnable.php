<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/** @psalm-suppress PropertyNotSetInConstructor */
#[\Attribute(\Attribute::TARGET_CLASS)]
class UniqueEnable extends Constraint
{
    public string $fieldName = 'enable';
    public string $message = 'unique_enable.cannot_enable_another';

    public function getTargets(): array
    {
        return [self::CLASS_CONSTRAINT];
    }
}
