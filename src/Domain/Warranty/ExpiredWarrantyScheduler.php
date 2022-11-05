<?php

namespace App\Domain\Warranty;

use App\Domain\DateTimeFactoryInterface;
use App\Domain\SchedulerInterface;
use App\Warranty\ExpiredWarrantySchedulerInterface;
use Doctrine\ORM\EntityManagerInterface;

class ExpiredWarrantyScheduler implements ExpiredWarrantySchedulerInterface
{
    public function __construct(
        private readonly WarrantyRepositoryInterface $warrantyRepository,
        private readonly SchedulerInterface $scheduler,
        private readonly DateTimeFactoryInterface $dateTimeFactory,
        private readonly EntityManagerInterface $entityManager
    ) {
    }

    public function scheduleExpiredWarranty(): void
    {
        foreach ($this->warrantyRepository->findExpiredWarranty() as $expiredWarranty) {
            $this->scheduler->schedulePing($expiredWarranty);
            $expiredWarranty->setPingPlannedAt($this->dateTimeFactory::createNow());
        }

        $this->entityManager->flush();
    }
}
