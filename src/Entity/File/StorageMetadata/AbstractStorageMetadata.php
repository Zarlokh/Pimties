<?php

namespace App\Entity\File\StorageMetadata;

use App\Utils\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;

/** @psalm-suppress PossiblyNullPropertyAssignmentValue */
#[Entity]
#[Table(name: 'storage_metadata')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string', length: 20)]
#[DiscriminatorMap(['file_system' => FileSystemStorageMetadata::class])]
abstract class AbstractStorageMetadata
{
    use EntityIdTrait;

    #[Column(type: 'string')]
    private string $filepath;
    #[Column(type: 'string')]
    private string $originalFilename;

    public function __construct(string $filepath, string $originalFilename)
    {
        $this->filepath = $filepath;
        $this->originalFilename = $originalFilename;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }

    public function setFilepath(?string $filepath): self
    {
        $this->filepath = $filepath;

        return $this;
    }

    public function getOriginalFilename(): ?string
    {
        return $this->originalFilename;
    }

    public function setOriginalFilename(?string $originalFilename): self
    {
        $this->originalFilename = $originalFilename;

        return $this;
    }
}
