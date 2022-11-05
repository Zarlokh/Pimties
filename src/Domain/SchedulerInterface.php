<?php

namespace App\Domain;

use App\Entity\PingeableInterface;

interface SchedulerInterface
{
    public function schedulePing(PingeableInterface $pingeable): void;
}
