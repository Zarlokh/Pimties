<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\Product\AbstractProductConfiguration;
use App\Utils\ClassUtils;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

/** @psalm-suppress PropertyNotSetInConstructor */
class ProductConfigurationCrudController extends AbstractInheritCrudController
{
    public static function getEntityFqcn(): string
    {
        return AbstractProductConfiguration::class;
    }

    protected function getFields(): array
    {
        return [
            NumberField::new('warrantyTime', sprintf('%s.warranty_time', ClassUtils::getOnlyClassSnakeCase($this::getEntityFqcn()))),
        ];
    }
}
