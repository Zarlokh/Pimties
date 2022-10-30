<?php

namespace App\ProductConfiguration;

use App\Entity\Configuration\Product\AbstractProductConfiguration;
use App\Entity\Warranty;
use App\Exception\NoProductConfigurationFoundException;
use App\Repository\Configuration\AbstractProductConfigurationRepository;
use App\Repository\Configuration\NewProductConfigurationRepository;
use App\Repository\Configuration\SecondHandProductConfigurationRepository;

class ProductConfigurationStrategy
{
    /** @var AbstractProductConfigurationRepository[] */
    private readonly iterable $repositories;

    public function __construct(
        NewProductConfigurationRepository $newProductConfigurationRepository,
        SecondHandProductConfigurationRepository $secondHandProductConfigurationRepository
    ) {
        $this->repositories = [
          Warranty::NEW_PRODUCT => $newProductConfigurationRepository,
          Warranty::SECOND_HAND_PRODUCT => $secondHandProductConfigurationRepository
        ];
    }

    public function getProductConfigurationForWarranty(Warranty $warranty): AbstractProductConfiguration
    {
        $productConfiguration = $this->repositories[$warranty->isSecondHandProduct() ? Warranty::SECOND_HAND_PRODUCT : Warranty::NEW_PRODUCT]->findProductConfiguration();

        if (! $productConfiguration) {
            throw new NoProductConfigurationFoundException('No product configuration found for warranty ' . ($warranty->isSecondHandProduct() ? 'second hand' : 'new product'));
        }

        return $productConfiguration;
    }
}
