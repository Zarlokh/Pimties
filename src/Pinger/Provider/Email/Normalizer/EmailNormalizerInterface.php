<?php

namespace App\Pinger\Provider\Email\Normalizer;

use App\Entity\PingeableInterface;
use App\Pinger\Provider\Email\EmailModel;

interface EmailNormalizerInterface
{
    public function normalize(PingeableInterface $pingeable): EmailModel;
}
