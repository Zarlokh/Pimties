<?php

namespace App\Entity\Configuration\Product;

use App\Repository\Configuration\Product\SecondHandProductConfigurationRepository;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: SecondHandProductConfigurationRepository::class)]
class SecondHandProductConfiguration extends AbstractProductConfiguration
{
    public function getAdminListName(): string
    {
        return 'Produit d\'occasion';
    }
}
