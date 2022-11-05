<?php

namespace App\Repository;

use App\Domain\Warranty\WarrantyRepositoryInterface;
use App\Entity\Warranty;
use App\Factory\DateTimeFactory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WarrantyRepository extends ServiceEntityRepository implements WarrantyRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Warranty::class);
    }

    /**
     * @psalm-suppress MixedInferredReturnType
     * @psalm-suppress MixedReturnStatement
     * @psalm-suppress TooManyArguments
     */
    public function findExpiredWarranty(?\DateTimeInterface $currentDate = null): array
    {
        $qb = $this->createQueryBuilder('w');

        $qb
            ->where(
                $qb->expr()->isNull('w.pingPlannedAt'),
                $qb->expr()->lte('w.endDate', ':date')
            )
            ->setParameter('date', $currentDate ?? DateTimeFactory::createNow())
        ;

        return $qb->getQuery()->getResult();
    }
}
