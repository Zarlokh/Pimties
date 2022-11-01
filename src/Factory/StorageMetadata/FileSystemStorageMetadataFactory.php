<?php

namespace App\Factory\StorageMetadata;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Entity\File\StorageMetadata\FileSystemStorageMetadata;

class FileSystemStorageMetadataFactory implements StorageMetadataFactoryInterface
{
    public function createStorageMetadata(string $filepath, string $originalFilename): AbstractStorageMetadata
    {
        return new FileSystemStorageMetadata($filepath, $originalFilename);
    }
}
