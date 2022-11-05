<?php

namespace App\MessageHandler;

use App\Command\PingPingeableCommand;
use App\Message\PingInfoMessage;
use App\Utils\Traits\MessageHandler\MessageHandlerCallCommandTrait;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

/** @psalm-suppress MissingConstructor */
#[AsMessageHandler]
class PingMessageHandler
{
    use MessageHandlerCallCommandTrait;

    public function __invoke(PingInfoMessage $pingInfoMessage)
    {
        $this->callCommand(PingPingeableCommand::NAME, [
            PingPingeableCommand::ARG_CLASSNAME => $pingInfoMessage->getClassname(),
            PingPingeableCommand::ARG_ID => $pingInfoMessage->getId(),
        ]);
    }
}
