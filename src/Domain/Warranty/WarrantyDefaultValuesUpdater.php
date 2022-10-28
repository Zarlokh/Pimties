<?php

namespace App\Domain\Warranty;

use App\Entity\Warranty;
use App\Strategy\ProductConfigurationStrategy;
use App\Utils\DateTimeUtils;
use App\Warranty\WarrantyEndDateUpdaterInterface;

class WarrantyDefaultValuesUpdater implements WarrantyEndDateUpdaterInterface
{
    public function __construct(
        private readonly DateTimeUtils $dateTimeUtils,
        private readonly ProductConfigurationStrategy $productConfigurationStrategy
    ) {
    }

    /** @psalm-suppress PossiblyNullArgument */
    public function update(Warranty $warranty): void
    {
        if (! $warranty->getWarrantyTime()) {
            $warranty->setWarrantyTime($this->productConfigurationStrategy->getProductConfigurationForWarranty($warranty)->getWarrantyTime());
        }

        $warranty->setEndDate($this->dateTimeUtils->addYears($warranty->getStartDate(), $warranty->getWarrantyTime()));
    }
}
