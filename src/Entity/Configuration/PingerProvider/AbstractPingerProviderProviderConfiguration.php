<?php

namespace App\Entity\Configuration\PingerProvider;

use App\Repository\Configuration\PingerProvider\PingerProviderConfigurationRepository;
use App\Utils\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;

#[Entity(repositoryClass: PingerProviderConfigurationRepository::class)]
#[Table(name: 'pinger_provider_configuration')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string', length: 20)]
#[DiscriminatorMap(['slack' => SlackPingerProviderConfiguration::class, 'email' => EmailPingerProviderConfiguration::class])]
abstract class AbstractPingerProviderProviderConfiguration implements PingerProviderConfigurationInterface
{
    use EntityIdTrait;

    #[Column(type: 'boolean')]
    private bool $enable = false;

    public function isEnable(): bool
    {
        return $this->enable;
    }

    public function setEnable(bool $enable): self
    {
        $this->enable = $enable;

        return $this;
    }
}
