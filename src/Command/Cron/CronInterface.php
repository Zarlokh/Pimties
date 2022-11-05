<?php

namespace App\Command\Cron;

use App\Scheduler\ScheduleCronInfoInterface;

interface CronInterface
{
    public function shouldBeScheduled(): bool;

    public function createScheduleCronInfo(): ScheduleCronInfoInterface;
}
