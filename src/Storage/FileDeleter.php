<?php

namespace App\Storage;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Exception\NoStorageProviderConfigurationEnableException;
use App\Repository\Configuration\StorageProvider\StorageProviderConfigurationRepository;
use App\Storage\Provider\StorageProviderLocator;

class FileDeleter
{
    public function __construct(
        private readonly StorageProviderLocator $storageProviderLocator,
        private readonly StorageProviderConfigurationRepository $providerConfigurationRepository
    ) {
    }

    public function deleteFile(AbstractStorageMetadata $storageMetadata): void
    {
        $enableStorageProviderConfiguration = $this->providerConfigurationRepository->findEnable();

        if (!$enableStorageProviderConfiguration) {
            throw new NoStorageProviderConfigurationEnableException('Aucune configuration de stockage a été configuré');
        }

        $this->storageProviderLocator->getProviderByConfiguration($enableStorageProviderConfiguration)->delete($storageMetadata);
    }
}
