<?php

namespace App\Entity\Configuration\PingerProvider;

use App\Utils\Traits\AllChildOnSameCrudControllerTrait;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class SlackPingerProviderConfiguration extends AbstractPingerProviderConfiguration
{
    use AllChildOnSameCrudControllerTrait;
}
