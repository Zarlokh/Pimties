<?php

namespace App\Repository\Configuration\StorageProvider;

use App\Entity\Configuration\StorageProvider\AbstractStorageProviderConfiguration;
use App\Entity\Configuration\StorageProvider\StorageProviderConfigurationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class StorageProviderConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractStorageProviderConfiguration::class);
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     */
    public function findEnable(): ?StorageProviderConfigurationInterface
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->eq('p.enable', true)
            )
        ;

        return $qb->getQuery()->getOneOrNullResult();
    }
}
