<?php

namespace App\Factory\PingInfo;

use App\Entity\PingeableInterface;
use App\Scheduler\PingInfoInterface;

interface PingInfoFactoryInterface
{
    public function create(PingeableInterface $pingeable): PingInfoInterface;
}
