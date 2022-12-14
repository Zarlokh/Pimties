<?php

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\ScheduleCronInfoMessage;
use App\Utils\Traits\MessageHandler\MessageHandlerCallCommandTrait;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/** @psalm-suppress MissingConstructor */
#[AsMessageHandler]
class ScheduleCronInfoMessageHandler
{
    use MessageHandlerCallCommandTrait;

    public function __invoke(ScheduleCronInfoMessage $scheduleCronInfoMessage)
    {
        $this->callCommand($scheduleCronInfoMessage->getCommandName(), $scheduleCronInfoMessage->getArgs(), $scheduleCronInfoMessage->getOptions());
    }
}
