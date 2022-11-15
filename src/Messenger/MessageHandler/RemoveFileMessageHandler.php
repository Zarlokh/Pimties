<?php

namespace App\Messenger\MessageHandler;

use App\Messenger\Message\RemoveFileMessage;
use App\Storage\FileDeleter;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class RemoveFileMessageHandler
{
    public function __construct(private readonly FileDeleter $fileDeleter)
    {
    }

    public function __invoke(RemoveFileMessage $removeFileMessage)
    {
        $this->fileDeleter->deleteFile($removeFileMessage->getAbstractStorageMetadata());
    }
}
