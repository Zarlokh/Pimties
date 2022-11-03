<?php

namespace App\Message;

use App\Entity\File\StorageMetadata\AbstractStorageMetadata;

class RemoveFileMessage implements AsyncMessageInterface
{
    public function __construct(private readonly AbstractStorageMetadata $abstractStorageMetadata)
    {
    }

    public function getAbstractStorageMetadata(): AbstractStorageMetadata
    {
        return $this->abstractStorageMetadata;
    }
}
