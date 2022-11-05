<?php

namespace App\Command\Cron;

use App\Factory\Message\ScheduleCronInfoMessageFactory;
use App\Scheduler\ScheduleCronInfoInterface;
use App\Warranty\ExpiredWarrantySchedulerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SchedulePingExpiredWarrantyCommand extends AbstractCronCommand
{
    public function __construct(private readonly ExpiredWarrantySchedulerInterface $expiredWarrantyScheduler)
    {
        parent::__construct('app:cron:schedule-ping-expired-warranty');
    }

    protected function configure(): void
    {
        $this
            ->addDateTimePattern('*-*-* *:*')
            ->setDescription('Parcourt toutes les garanties expirées et planifie un ping')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->expiredWarrantyScheduler->scheduleExpiredWarranty();

        return 0;
    }

    public function createScheduleCronInfo(): ScheduleCronInfoInterface
    {
        if (!($name = $this->getName())) {
            throw new \LogicException('La commande semble ne pas avoir de name ? '.get_class($this));
        }

        return ScheduleCronInfoMessageFactory::create($name);
    }
}
