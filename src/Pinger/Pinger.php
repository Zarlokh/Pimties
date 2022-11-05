<?php

namespace App\Pinger;

use App\Entity\PingeableInterface;
use App\Factory\DateTimeFactory;
use App\Repository\Configuration\PingerProvider\PingerProviderConfigurationRepository;
use Doctrine\ORM\EntityManagerInterface;

class Pinger
{
    public function __construct(
        protected readonly PingerFinder $pingerFinder,
        protected readonly PingerProviderConfigurationRepository $pingerProviderConfigurationRepository,
        protected readonly EntityManagerInterface $entityManager
    ) {
    }

    public function ping(PingeableInterface $pingeable): void
    {
        foreach ($this->pingerProviderConfigurationRepository->findAllEnable() as $pingerProviderProviderConfiguration) {
            $this->pingerFinder->ping($pingeable, $pingerProviderProviderConfiguration);
            $pingeable->setPingedAt(DateTimeFactory::createNow());
        }
        $this->entityManager->flush();
    }
}
