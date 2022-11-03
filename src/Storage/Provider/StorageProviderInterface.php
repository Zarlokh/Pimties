<?php

namespace App\Storage\Provider;

use App\Entity\Configuration\StorageProvider\StorageProviderConfigurationInterface;
use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Factory\StorageMetadata\StorageMetadataFactoryInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface StorageProviderInterface
{
    public function support(StorageProviderConfigurationInterface $storageProviderConfiguration): bool;

    public function supportForStorageMetadata(AbstractStorageMetadata $abstractStorageMetadata): bool;

    public function upload(UploadedFile $file): string;

    public function getStorageMetadataFactory(): StorageMetadataFactoryInterface;

    public function delete(AbstractStorageMetadata $storageMetadata): void;
}
