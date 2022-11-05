<?php

namespace App\Scheduler\Provider;

use App\Message\PingInfoMessage;
use App\Message\ScheduleCronInfoMessage;
use App\Scheduler\PingInfoInterface;
use App\Scheduler\ScheduleCronInfoInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerSchedulerProvider implements SchedulerProviderInterface
{
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function support(ScheduleCronInfoInterface $scheduleCronInfo): bool
    {
        return $scheduleCronInfo instanceof ScheduleCronInfoMessage;
    }

    public function supportPingInfo(PingInfoInterface $pingInfo): bool
    {
        return $pingInfo instanceof PingInfoMessage;
    }

    public function schedulePingInfo(PingInfoInterface $pingInfo): void
    {
        $this->messageBus->dispatch($pingInfo);
    }

    public function schedule(ScheduleCronInfoInterface $scheduleCronInfo): void
    {
        /** @var ScheduleCronInfoMessage $scheduleCronInfo */
        $this->messageBus->dispatch($scheduleCronInfo);
    }
}
