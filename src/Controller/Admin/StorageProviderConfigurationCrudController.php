<?php

namespace App\Controller\Admin;

use App\Entity\Configuration\StorageProvider\AbstractStorageProviderConfiguration;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

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
            TextField::new('name', 'storage_provider_configuration.name')->setMaxLength(30),
            BooleanField::new('enable', 'storage_provider_configuration.enable'),
        ];
    }
}
