<?php

namespace App\Storage\Provider;

use App\Entity\File\File;
use App\Entity\File\StorageMetadata\AbstractStorageMetadata;

interface StorageUrlConverterInterface
{
    public function getPublicUrl(File $file): string;

    public function support(AbstractStorageMetadata $storageMetadata): bool;
}
