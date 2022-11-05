<?php

namespace App\Factory\Message;

use App\Message\ScheduleCronInfoMessage;

class ScheduleCronInfoMessageFactory
{
    public static function create(string $commandName, array $args = [], array $options = []): ScheduleCronInfoMessage
    {
        return new ScheduleCronInfoMessage($commandName, $args, $options);
    }
}
