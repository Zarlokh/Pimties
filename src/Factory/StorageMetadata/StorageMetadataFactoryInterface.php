<?php

namespace App\Factory\StorageMetadata;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;

interface StorageMetadataFactoryInterface
{
    public function createStorageMetadata(string $filepath, string $originalFilename): AbstractStorageMetadata;
}
