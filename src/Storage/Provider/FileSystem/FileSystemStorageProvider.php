<?php

namespace App\Storage\Provider\FileSystem;

use App\Entity\Configuration\StorageProvider\FileSystemStorageProviderConfiguration;
use App\Entity\Configuration\StorageProvider\StorageProviderConfigurationInterface;
use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Entity\File\StorageMetadata\FileSystemStorageMetadata;
use App\Factory\StorageMetadata\FileSystemStorageMetadataFactory;
use App\Factory\StorageMetadata\StorageMetadataFactoryInterface;
use App\Storage\Provider\StorageProviderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileSystemStorageProvider implements StorageProviderInterface
{
    public function __construct(
        private readonly string $defaultUploadedDir,
        private readonly FileSystemStorageMetadataFactory $fileSystemStorageMetadataFactory
    ) {
    }

    public function support(StorageProviderConfigurationInterface $storageProviderConfiguration): bool
    {
        return $storageProviderConfiguration instanceof FileSystemStorageProviderConfiguration;
    }

    public function supportForStorageMetadata(AbstractStorageMetadata $abstractStorageMetadata): bool
    {
        return $abstractStorageMetadata instanceof FileSystemStorageMetadata;
    }

    public function upload(UploadedFile $file): string
    {
        $uniqFilename = uniqid('', true);
        $file->move($this->defaultUploadedDir, $uniqFilename);

        return $this->defaultUploadedDir.DIRECTORY_SEPARATOR.$uniqFilename;
    }

    public function delete(AbstractStorageMetadata $storageMetadata): void
    {
        $filepath = $storageMetadata->getFilepath();
        /** @var FileSystemStorageMetadata $storageMetadata */
        if (!$filepath || !file_exists($filepath)) {
            return;
        }
        unlink($filepath);
    }

    public function getStorageMetadataFactory(): StorageMetadataFactoryInterface
    {
        return $this->fileSystemStorageMetadataFactory;
    }
}
