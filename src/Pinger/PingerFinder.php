<?php

namespace App\Pinger;

use App\Entity\Configuration\PingerProvider\PingerProviderConfigurationInterface;
use App\Entity\PingeableInterface;
use App\Exception\NoPingerFoundException;
use App\Pinger\Provider\PingerProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class PingerFinder
{
    /**
     * @param PingerProviderInterface[] $pingers
     * @psalm-suppress InvalidAttribute
     */
    public function __construct(
        #[TaggedIterator("app.pinger_provider")] private readonly iterable $pingers
    ) {
    }

    public function ping(PingeableInterface $pingeable, PingerProviderConfigurationInterface $pingerConfiguration): void
    {
        $this->getPingerByConfiguration($pingerConfiguration)->ping($pingeable, $pingerConfiguration);
    }

    /** @psalm-suppress MixedInferredReturnType */
    private function getPingerByConfiguration(PingerProviderConfigurationInterface $pingerConfiguration): PingerProviderInterface
    {
        foreach ($this->pingers as $pinger) {
            if ($pinger->support($pingerConfiguration)) {
                return $pinger;
            }
        }
        throw new NoPingerFoundException(sprintf('No pinger found for configuration %d %s', ($pingerConfiguration->getId() ?? 'no id'), get_class($pingerConfiguration)));
    }
}
