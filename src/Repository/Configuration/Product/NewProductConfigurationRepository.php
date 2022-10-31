<?php

namespace App\Repository\Configuration\Product;

use App\Entity\Configuration\Product\NewProductConfiguration;
use Doctrine\Persistence\ManagerRegistry;

class NewProductConfigurationRepository extends AbstractProductConfigurationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewProductConfiguration::class);
    }
}
