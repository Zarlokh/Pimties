<?php

namespace App\EntityListener;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;

class OnPrePostUpdateStorageMetadataEntityListener
{
    public function __construct()
    {
    }

    public function postRemove(AbstractStorageMetadata $storageMetadata): void
    {
        // TODO : Use messenger to remove async deleted file
    }
}
