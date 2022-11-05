<?php

namespace App\Scheduler;

use App\Domain\SchedulerInterface;
use App\Entity\PingeableInterface;
use App\Exception\NoSchedulerProviderFoundException;
use App\Factory\PingInfo\PingInfoFactory;
use App\Scheduler\Provider\SchedulerProviderInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class Scheduler implements SchedulerInterface
{
    /**
     * @param SchedulerProviderInterface[] $schedulerProviders
     *
     * @psalm-suppress InvalidAttribute
     */
    public function __construct(
        #[TaggedIterator('app.scheduler_provider')] private readonly iterable $schedulerProviders,
        private readonly PingInfoFactory $pingInfoFactory
    ) {
    }

    public function schedule(ScheduleCronInfoInterface $scheduleCronInfo): void
    {
        $this->getProvider($scheduleCronInfo)->schedule($scheduleCronInfo);
    }

    public function schedulePing(PingeableInterface $pingeable): void
    {
        $pingInfo = $this->pingInfoFactory->create($pingeable);
        $this->getProviderForPingInfo($pingInfo)->schedulePingInfo($pingInfo);
    }

    protected function getProviderForPingInfo(PingInfoInterface $pingInfo): SchedulerProviderInterface
    {
        foreach ($this->schedulerProviders as $schedulerProvider) {
            if ($schedulerProvider->supportPingInfo($pingInfo)) {
                return $schedulerProvider;
            }
        }

        throw new NoSchedulerProviderFoundException(sprintf('Aucun SchedulerProvider trouvé pour le ping info %s', get_class($pingInfo)));
    }

    protected function getProvider(ScheduleCronInfoInterface $scheduleCronInfo): SchedulerProviderInterface
    {
        foreach ($this->schedulerProviders as $schedulerProvider) {
            if ($schedulerProvider->support($scheduleCronInfo)) {
                return $schedulerProvider;
            }
        }

        throw new NoSchedulerProviderFoundException(sprintf('Aucun SchedulerProvider trouvé pour le cron info %s', get_class($scheduleCronInfo)));
    }
}
