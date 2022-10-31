<?php

namespace App\Domain\Warranty;

use App\Entity\Warranty;
use App\ProductConfiguration\ProductConfigurationStrategy;
use App\Utils\DateTimeUtils;
use App\Warranty\WarrantyCalculatedValuesUpdaterInterface;

class WarrantyCalculatedValuesUpdater implements WarrantyCalculatedValuesUpdaterInterface
{
    public function __construct(
        private readonly DateTimeUtils $dateTimeUtils,
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
