<?php

namespace App\EntityListener;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Storage\FileDeleter;

class OnPrePostUpdateStorageMetadataEntityListener
{
    public function __construct(private readonly FileDeleter $deleter)
    {
    }

    public function postRemove(AbstractStorageMetadata $storageMetadata): void
    {
        $this->deleter->deleteAsyncFile($storageMetadata);
    }
}
