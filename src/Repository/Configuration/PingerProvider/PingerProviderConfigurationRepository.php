<?php

namespace App\Repository\Configuration\PingerProvider;

use App\Entity\Configuration\PingerProvider\AbstractPingerProviderProviderConfiguration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PingerProviderConfigurationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, AbstractPingerProviderProviderConfiguration::class);
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     * @return AbstractPingerProviderProviderConfiguration[]
     */
    public function findAllEnable(): array
    {
        $qb = $this->createQueryBuilder('p');
        $qb
            ->where(
                $qb->expr()->eq('p.enable', true)
            )
        ;

        return $qb->getQuery()->getResult();
    }
}
