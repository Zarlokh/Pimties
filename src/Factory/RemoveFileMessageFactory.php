<?php

namespace App\Factory;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Message\RemoveFileMessage;

class RemoveFileMessageFactory
{
    public static function createForStorageMetadata(AbstractStorageMetadata $abstractStorageMetadata): RemoveFileMessage
    {
        return new RemoveFileMessage($abstractStorageMetadata);
    }
}
