<?php

namespace App\Entity\Configuration\Product;

use App\Repository\Configuration\Product\NewProductConfigurationRepository;
use App\Utils\Traits\AllChildOnSameCrudControllerTrait;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: NewProductConfigurationRepository::class)]
class NewProductConfiguration extends AbstractProductConfiguration
{
    use AllChildOnSameCrudControllerTrait;
}
