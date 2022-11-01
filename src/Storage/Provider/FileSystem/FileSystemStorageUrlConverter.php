<?php

namespace App\Storage\Provider\FileSystem;

use App\Entity\File\File;
use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Entity\File\StorageMetadata\FileSystemStorageMetadata;
use App\Storage\Provider\StorageUrlConverterInterface;
use Symfony\Component\Routing\RouterInterface;

class FileSystemStorageUrlConverter implements StorageUrlConverterInterface
{
    public function __construct(private readonly RouterInterface $router)
    {
    }

    public function getPublicUrl(File $file): string
    {
        return $this->router->generate('download_file', ['id' => $file->getId()]);
    }

    public function support(AbstractStorageMetadata $storageMetadata): bool
    {
        return $storageMetadata instanceof FileSystemStorageMetadata;
    }
}
