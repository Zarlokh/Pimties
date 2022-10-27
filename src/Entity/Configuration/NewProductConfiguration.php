<?php

namespace App\Entity\Configuration;

use App\Repository\Configuration\NewProductConfigurationRepository;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: NewProductConfigurationRepository::class)]
class NewProductConfiguration extends AbstractProductConfiguration
{
}
