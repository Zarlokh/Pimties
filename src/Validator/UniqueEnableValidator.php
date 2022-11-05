<?php

namespace App\Validator;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/** @psalm-suppress PropertyNotSetInConstructor */
class UniqueEnableValidator extends ConstraintValidator
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!is_object($value) || !$constraint instanceof UniqueEnable) {
            return;
        }

        $propertyAccessor = PropertyAccess::createPropertyAccessor();
        /** @var bool $isEnable */
        $isEnable = $propertyAccessor->getValue($value, $constraint->fieldName);

        if (!$isEnable) {
            return;
        }

        $repository = $this->entityManager->getRepository(get_class($value));
        $entityEnabled = $repository->findOneBy([
            $constraint->fieldName => true,
        ]);

        if (!$entityEnabled) {
            return;
        }

        /** @var ?int $idOfValue */
        $idOfValue = $propertyAccessor->getValue($value, 'id');
        /** @var int $idOfEntityEnable */
        $idOfEntityEnable = $propertyAccessor->getValue($entityEnabled, 'id');

        if (!$idOfValue || $idOfValue !== $idOfEntityEnable) {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}
