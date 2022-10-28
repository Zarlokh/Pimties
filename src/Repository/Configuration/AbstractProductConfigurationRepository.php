<?php

namespace App\Repository\Configuration;

use App\Entity\Configuration\AbstractProductConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractProductConfigurationRepository extends ServiceEntityRepository
{
    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function findProductConfiguration(): ?AbstractProductConfiguration
    {
        return $this->createQueryBuilder('c')->setMaxResults(1)->getQuery()->getOneOrNullResult();
    }
}
