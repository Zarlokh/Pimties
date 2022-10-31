<?php

namespace App\Pinger;

use App\Entity\PingeableInterface;
use App\Repository\Configuration\PingerProvider\PingerProviderConfigurationRepository;

class Pinger
{
    public function __construct(
        protected readonly PingerFinder $pingerFinder,
        protected readonly PingerProviderConfigurationRepository $pingerProviderConfigurationRepository
    ) {
    }

    public function ping(PingeableInterface $pingeable): void
    {
        foreach ($this->pingerProviderConfigurationRepository->findAllEnable() as $pingerProviderProviderConfiguration) {
            $this->pingerFinder->ping($pingeable, $pingerProviderProviderConfiguration);
        }
    }
}
