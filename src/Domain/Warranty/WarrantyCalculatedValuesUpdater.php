<?php

namespace App\Domain\Warranty;

use App\Entity\Warranty;
use App\Strategy\ProductConfigurationStrategy;
use App\Utils\DateTimeUtils;
use App\Warranty\WarrantyEndDateUpdaterInterface;

class WarrantyCalculatedValuesUpdater implements WarrantyEndDateUpdaterInterface
{
    public function __construct(
        private readonly DateTimeUtils                $dateTimeUtils,
        private readonly ProductConfigurationStrategy $productConfigurationStrategy
    ) {
    }

    /** @psalm-suppress PossiblyNullArgument */
    public function update(Warranty $warranty): void
    {
        if (!$warranty->hasExtendedWarrantyTime()) {
            $warranty->setExtendedWarrantyTime(null);
        }

        $warrantyTimeToCalculateEndDate = $warranty->getExtendedWarrantyTime() ?? $this->productConfigurationStrategy->getProductConfigurationForWarranty($warranty)->getWarrantyTime();

        $warranty->setEndDate($this->dateTimeUtils->addYears($warranty->getStartDate(), $warrantyTimeToCalculateEndDate));
    }
}