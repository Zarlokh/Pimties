<?php

namespace App\Storage;

use App\Entity\File\File;
use App\Exception\NoStorageProviderConfigurationEnableException;
use App\Repository\Configuration\StorageProvider\StorageProviderConfigurationRepository;
use App\Storage\Provider\StorageProviderLocator;

class FileUploader
{
    public function __construct(
        private readonly StorageProviderLocator $storageProviderLocator,
        private readonly StorageProviderConfigurationRepository $providerConfigurationRepository
    ) {
    }

    public function uploadFile(File $file): void
    {
        $enableStorageProviderConfiguration = $this->providerConfigurationRepository->findEnable();

        if (!$enableStorageProviderConfiguration) {
            throw new NoStorageProviderConfigurationEnableException('Aucune configuration de stockage a été configuré');
        }

        $provider = $this->storageProviderLocator->getProviderByConfiguration($enableStorageProviderConfiguration);

        $uploadedFile = $file->getTransientUploadedFile();

        if (!$uploadedFile) {
            throw new \LogicException('Should never happened, transientUploadedFile is null');
        }

        $filepath = $provider->upload($uploadedFile);
        $file->setStorageMetadata($provider->getStorageMetadataFactory()->createStorageMetadata($filepath, $uploadedFile->getClientOriginalName()));
    }
}
