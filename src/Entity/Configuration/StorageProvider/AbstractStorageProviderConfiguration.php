<?php

namespace App\Entity\Configuration\StorageProvider;

use App\Entity\Configuration\AllChildOnSameCrudControllerInterface;
use App\Repository\Configuration\StorageProvider\StorageProviderConfigurationRepository;
use App\Utils\Traits\EntityIdTrait;
use App\Validator\UniqueEnable;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;
use Symfony\Component\Validator\Constraints\Length;

#[Entity(repositoryClass: StorageProviderConfigurationRepository::class)]
#[Table(name: 'storage_provider_configuration')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string', length: 20)]
#[DiscriminatorMap(['file_system' => FileSystemStorageProviderConfiguration::class, 'google_drive' => GoogleDriveStorageProviderConfiguration::class])]
#[UniqueEnable]
abstract class AbstractStorageProviderConfiguration implements AllChildOnSameCrudControllerInterface, StorageProviderConfigurationInterface
{
    use EntityIdTrait;

    #[Column(type: 'string', length: 30)]
    #[Length(max: 30)]
    private ?string $name = null;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }
}
