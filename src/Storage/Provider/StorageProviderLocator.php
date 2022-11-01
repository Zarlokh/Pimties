<?php

namespace App\Storage\Provider;

use App\Entity\Configuration\StorageProvider\StorageProviderConfigurationInterface;
use App\Exception\NoStorageProviderFoundException;
use App\Repository\Configuration\StorageProvider\StorageProviderConfigurationRepository;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class StorageProviderLocator
{
    /**
     * @param StorageProviderInterface[] $providers
     *
     * @psalm-suppress InvalidAttribute
     */
    public function __construct(
        #[TaggedIterator('app.storage_provider')] private readonly iterable $providers,
        private readonly StorageProviderConfigurationRepository $providerConfigurationRepository
    ) {
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
