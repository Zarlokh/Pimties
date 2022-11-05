<?php

namespace App\Scheduler;

use App\Command\Cron\CronInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class CronCrawlerScheduler
{
    /**
     * @param CronInterface[] $crons
     *
     * @psalm-suppress InvalidAttribute
     */
    public function __construct(
        #[TaggedIterator('app.cron_command')] private readonly iterable $crons,
        private readonly Scheduler $scheduler
    ) {
    }

    public function schedule(): void
    {
        foreach ($this->crons as $cron) {
            if ($cron->shouldBeScheduled()) {
                $this->scheduler->schedule($cron->createScheduleCronInfo());
            }
        }
    }
}
