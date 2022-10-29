<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class RequireToggleHideOtherFields extends Constraint
{
    final public const OPTION_TOGGLE_FIELD = 'toggleField';
    final public const OPTION_REQUIRED_FIELDS = 'requiredFields';

    /** @psalm-suppress PropertyNotSetInConstructor */
    public string $toggleField;
    /**
     * @psalm-suppress PropertyNotSetInConstructor
     * @var string[]
     */
    public array $requiredFields;
    public string $message = 'Veuillez renseigner ce champs';
    /** @psalm-suppress PropertyNotSetInConstructor */
    public $groups;

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
