<?php

namespace App\Domain\Warranty;

use App\Entity\Warranty;

interface WarrantyRepositoryInterface
{
    /** @return Warranty[] */
    public function findExpiredWarranty(?\DateTimeInterface $currentDate = null): array;
}
