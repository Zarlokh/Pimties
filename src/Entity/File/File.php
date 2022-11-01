<?php

namespace App\Entity\File;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Utils\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\HttpFoundation\File\UploadedFile;

#[Entity]
class File
{
    use EntityIdTrait;

    #[OneToOne(targetEntity: AbstractStorageMetadata::class, cascade: ['all'], orphanRemoval: true)]
    #[JoinColumn(name: 'metadata_id', fieldName: 'id')]
    private ?AbstractStorageMetadata $storageMetadata = null;
    private ?UploadedFile $transientUploadedFile = null;

    public function getTransientUploadedFile(): ?UploadedFile
    {
        return $this->transientUploadedFile;
    }

    public function setTransientUploadedFile(?UploadedFile $transientUploadedFile): void
    {
        $this->transientUploadedFile = $transientUploadedFile;
    }

    public function getStorageMetadata(): ?AbstractStorageMetadata
    {
        return $this->storageMetadata;
    }

    public function setStorageMetadata(?AbstractStorageMetadata $storageMetadata): self
    {
        $this->storageMetadata = $storageMetadata;

        return $this;
    }
}
