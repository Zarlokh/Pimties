<?php

namespace App\Repository\Configuration;

use App\Entity\Configuration\NewProductConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class NewProductConfigurationRepository extends AbstractProductConfigurationRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, NewProductConfiguration::class);
    }
}
