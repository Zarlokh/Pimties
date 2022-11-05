<?php

namespace App\Command;

use App\Scheduler\CronCrawlerScheduler;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class SchedulerCommand extends Command
{
    protected const OPTION_MAX_SCHEDULE_COUNT = 'max-schedule-count';
    protected const OPTION_INTERVAL_EACH_SCHEDULE = 'interval-each-schedule';

    public function __construct(private readonly CronCrawlerScheduler $cronCrawlerScheduler)
    {
        parent::__construct('app:cron:schedule');
    }

    protected function configure(): void
    {
        $this
            ->setDescription('Commande de planificateur de cron')
            ->addOption(self::OPTION_MAX_SCHEDULE_COUNT, '', InputOption::VALUE_REQUIRED, 'Nombre max de schedule avant de kill la commande', 300)
            ->addOption(self::OPTION_INTERVAL_EACH_SCHEDULE, '', InputOption::VALUE_REQUIRED, 'Temps d\'attente entre chaque "schedule all crons"', 60)
        ;
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = 0;
        $maxScheduled = $input->getOption(self::OPTION_MAX_SCHEDULE_COUNT);

        if (!is_numeric($maxScheduled)) {
            throw new \LogicException(sprintf('L\'option %s doit être une valeur numérique', self::OPTION_MAX_SCHEDULE_COUNT));
        }
        $sleepTime = $input->getOption(self::OPTION_INTERVAL_EACH_SCHEDULE);

        if (!is_numeric($sleepTime) || $sleepTime <= 0) {
            throw new \LogicException(sprintf('L\'option %s doit être une valeur numérique', self::OPTION_INTERVAL_EACH_SCHEDULE));
        }

        $sleepTime = (int) $sleepTime;

        while (true) {
            $this->cronCrawlerScheduler->schedule();

            if ($count++ > $maxScheduled) {
                break;
            }
            /** @psalm-suppress ArgumentTypeCoercion */
            sleep($sleepTime);
        }

        return 0;
    }
}
