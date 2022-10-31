<?php

namespace App\Validator;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/** @psalm-suppress PropertyNotSetInConstructor */
class RequireToggleHideOtherFieldsValidator extends ConstraintValidator
{
    public function __construct(private readonly ValidatorInterface $validator)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof RequireToggleHideOtherFields || (!is_object($value) && !is_array($value))) {
            return;
        }

        $propertyAccess = PropertyAccess::createPropertyAccessor();

        /** @var bool $toggleIsChecked */
        $toggleIsChecked = $propertyAccess->getValue($value, $constraint->toggleField);

        if (!$toggleIsChecked) {
            return;
        }

        foreach ($constraint->requiredFields as $requiredField) {
            /** @psalm-suppress MixedAssignment */
            $valueOfRequiredField = $propertyAccess->getValue($value, $requiredField);

            if (is_string($valueOfRequiredField)) {
                $valueOfRequiredField = trim($valueOfRequiredField);
            }

            /** @var ConstraintViolation $error */
            foreach ($this->validator->validate($valueOfRequiredField, [new NotBlank()]) as $error) {
                $this->context
                    ->buildViolation($error->getMessage())
                    ->atPath($requiredField)
                    ->addViolation()
                ;
            }
        }
    }
}
