<?php

namespace App\Repository\Configuration\Product;

use App\Entity\Configuration\Product\SecondHandProductConfiguration;
use Doctrine\Persistence\ManagerRegistry;

class SecondHandProductConfigurationRepository extends AbstractProductConfigurationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondHandProductConfiguration::class);
    }
}
