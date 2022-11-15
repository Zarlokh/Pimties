<?php

namespace App\Factory\PingInfo\Provider;

use App\Entity\PingeableInterface;
use App\Factory\PingInfo\PingInfoFactoryInterface;
use App\Messenger\Message\PingInfoMessage;
use App\Scheduler\PingInfoInterface;

class PingMessageFactory implements PingInfoFactoryInterface
{
    public function create(PingeableInterface $pingeable): PingInfoInterface
    {
        if (!($id = $pingeable->getId())) {
            throw new \LogicException('Le pingeable doit être préalablement inséré en base');
        }

        return new PingInfoMessage(get_class($pingeable), $id);
    }
}
