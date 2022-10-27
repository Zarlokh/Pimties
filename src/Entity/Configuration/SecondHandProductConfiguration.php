<?php

namespace App\Entity\Configuration;

use App\Repository\Configuration\SecondHandProductConfigurationRepository;
use Doctrine\ORM\Mapping\Entity;

#[Entity(repositoryClass: SecondHandProductConfigurationRepository::class)]
class SecondHandProductConfiguration extends AbstractProductConfiguration
{
}
