<?php

namespace App\Factory\Message;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Messenger\Message\RemoveFileMessage;

class RemoveFileMessageFactory
{
    public static function createForStorageMetadata(AbstractStorageMetadata $abstractStorageMetadata): RemoveFileMessage
    {
        return new RemoveFileMessage($abstractStorageMetadata);
    }
}
