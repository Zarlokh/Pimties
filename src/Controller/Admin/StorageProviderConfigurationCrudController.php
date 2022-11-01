<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\StorageProvider\AbstractStorageProviderConfiguration;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

/** @psalm-suppress PropertyNotSetInConstructor */
class StorageProviderConfigurationCrudController extends AbstractInheritCrudController
{
    public static function getEntityFqcn(): string
    {
        return AbstractStorageProviderConfiguration::class;
    }

    protected function getFields(): array
    {
        return [
            BooleanField::new('enable'),
        ];
    }
}
