<?php

namespace App\Pinger\Provider\Slack\Normalizer;

use App\Entity\PingeableInterface;
use App\Pinger\Provider\Slack\SlackModel;

interface SlackNormalizerInterface
{
    public function normalize(PingeableInterface $pingeable): SlackModel;
}
