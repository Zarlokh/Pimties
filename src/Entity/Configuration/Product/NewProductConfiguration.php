<?php

namespace App\Entity\Configuration\Product;

use App\Repository\Configuration\Product\NewProductConfigurationRepository;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: NewProductConfigurationRepository::class)]
class NewProductConfiguration extends AbstractProductConfiguration
{
    public function getAdminListName(): string
    {
        return 'Produit neuf';
    }
}
