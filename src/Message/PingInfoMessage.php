<?php

namespace App\Message;

use App\Scheduler\PingInfoInterface;

class PingInfoMessage implements AsyncMessageInterface, PingInfoInterface
{
    public function __construct(
        private readonly string $classname,
        private readonly int $id
    ) {
    }

    public function getClassname(): string
    {
        return $this->classname;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
