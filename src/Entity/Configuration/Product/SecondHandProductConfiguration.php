<?php

namespace App\Entity\Configuration\Product;

use App\Repository\Configuration\Product\SecondHandProductConfigurationRepository;
use App\Utils\Traits\AllChildOnSameCrudControllerTrait;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: SecondHandProductConfigurationRepository::class)]
class SecondHandProductConfiguration extends AbstractProductConfiguration
{
    use AllChildOnSameCrudControllerTrait;
}
