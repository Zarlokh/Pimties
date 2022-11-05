<?php

namespace App\Scheduler;

interface ScheduleCronInfoInterface
{
    public function getCommandName(): string;

    public function getArgs(): array;

    public function getOptions(): array;
}
