<?php

namespace App\Storage\Provider;

use App\Entity\Configuration\StorageProvider\StorageProviderConfigurationInterface;
use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Exception\NoStorageProviderFoundException;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class StorageProviderLocator
{
    /**
     * @param StorageProviderInterface[] $providers
     *
     * @psalm-suppress InvalidAttribute
     */
    public function __construct(
        #[TaggedIterator('app.storage_provider')] private readonly iterable $providers
    ) {
    }

    public function getProviderByStorageMetadata(AbstractStorageMetadata $abstractStorageMetadata): StorageProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->supportForStorageMetadata($abstractStorageMetadata)) {
                return $provider;
            }
        }

        throw new NoStorageProviderFoundException(sprintf('No storage provider found for storage metadata "%s"', get_class($abstractStorageMetadata)));
    }

    public function getProviderByConfiguration(StorageProviderConfigurationInterface $storageProviderConfiguration): StorageProviderInterface
    {
        foreach ($this->providers as $provider) {
            if ($provider->support($storageProviderConfiguration)) {
                return $provider;
            }
        }

        throw new NoStorageProviderFoundException(sprintf('No storage provider found for configuration "%s"', get_class($storageProviderConfiguration)));
    }
}
