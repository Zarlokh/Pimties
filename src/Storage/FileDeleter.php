<?php

namespace App\Storage;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Factory\Message\RemoveFileMessageFactory;
use App\Storage\Provider\StorageProviderLocator;
use Symfony\Component\Messenger\MessageBusInterface;

class FileDeleter
{
    public function __construct(
        private readonly StorageProviderLocator $storageProviderLocator,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function deleteFile(AbstractStorageMetadata $abstractStorageMetadata): void
    {
        $this->storageProviderLocator->getProviderByStorageMetadata($abstractStorageMetadata)->delete($abstractStorageMetadata);
    }

    public function deleteAsyncFile(AbstractStorageMetadata $storageMetadata): void
    {
        $this->messageBus->dispatch(RemoveFileMessageFactory::createForStorageMetadata($storageMetadata));
    }
}
