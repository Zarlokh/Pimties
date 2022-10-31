<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/** @psalm-suppress PropertyNotSetInConstructor */
#[\Attribute]
class RequireToggleHideOtherFields extends Constraint
{
    final public const OPTION_TOGGLE_FIELD = 'toggleField';
    final public const OPTION_REQUIRED_FIELDS = 'requiredFields';

    public string $toggleField;
    /** @var string[] */
    public array $requiredFields;
    public string $message = 'Veuillez renseigner ce champs';

    public function getRequiredOptions(): array
    {
        return [
            self::OPTION_TOGGLE_FIELD,
            self::OPTION_REQUIRED_FIELDS
        ];
    }

    public function getTargets(): string
    {
        return Constraint::CLASS_CONSTRAINT;
    }
}
