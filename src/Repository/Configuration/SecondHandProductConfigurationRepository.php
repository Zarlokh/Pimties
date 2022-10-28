<?php

namespace App\Repository\Configuration;

use App\Entity\Configuration\SecondHandProductConfiguration;
use Doctrine\Persistence\ManagerRegistry;

class SecondHandProductConfigurationRepository extends AbstractProductConfigurationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecondHandProductConfiguration::class);
    }
}
