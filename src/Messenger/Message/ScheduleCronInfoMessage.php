<?php

namespace App\Messenger\Message;

use App\Scheduler\ScheduleCronInfoInterface;

class ScheduleCronInfoMessage implements AsyncMessageInterface, ScheduleCronInfoInterface
{
    public function __construct(
        private readonly string $commandName,
        private readonly array $args = [],
        private readonly array $options = []
    ) {
    }

    public function getCommandName(): string
    {
        return $this->commandName;
    }

    public function getArgs(): array
    {
        return $this->args;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
