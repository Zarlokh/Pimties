<?php

namespace App\Factory\PingInfo;

use App\Entity\PingeableInterface;
use App\Factory\PingInfo\Provider\PingMessageFactory;
use App\Scheduler\PingInfoInterface;

class PingInfoFactory
{
    private const INDEX_DEFAULT = 'default';

    /** @var PingInfoFactoryInterface[] */
    private array $factories;

    public function __construct(
        PingMessageFactory $pingMessageFactory
    ) {
        $this->factories = [
            self::INDEX_DEFAULT => $pingMessageFactory,
        ];
    }

    public function create(PingeableInterface $pingeable): PingInfoInterface
    {
        $factory = $this->factories[get_class($pingeable)] ?? $this->factories[self::INDEX_DEFAULT];

        return $factory->create($pingeable);
    }
}
