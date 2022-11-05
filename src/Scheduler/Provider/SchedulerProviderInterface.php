<?php

namespace App\Scheduler\Provider;

use App\Scheduler\PingInfoInterface;
use App\Scheduler\ScheduleCronInfoInterface;

interface SchedulerProviderInterface
{
    public function support(ScheduleCronInfoInterface $scheduleCronInfo): bool;

    public function supportPingInfo(PingInfoInterface $pingInfo): bool;

    public function schedule(ScheduleCronInfoInterface $scheduleCronInfo): void;

    public function schedulePingInfo(PingInfoInterface $pingInfo): void;
}
