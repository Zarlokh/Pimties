<?php

namespace App\Pinger\Provider;

use App\Entity\Configuration\PingerProvider\PingerProviderConfigurationInterface;
use App\Entity\PingeableInterface;

interface PingerProviderInterface
{
    public function ping(PingeableInterface $pingeable, PingerProviderConfigurationInterface $pingerConfiguration): void;
    public function support(PingerProviderConfigurationInterface $pingerConfiguration): bool;
}
