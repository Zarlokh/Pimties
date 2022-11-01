<?php

namespace App\Storage;

use App\Entity\File\File;
use App\Entity\File\StorageMetadata\AbstractStorageMetadata;
use App\Exception\NoStorageUrlConverterFoundException;
use App\Storage\Provider\StorageUrlConverterInterface;
use Symfony\Component\DependencyInjection\Attribute\TaggedIterator;

class StorageUrlConverter
{
    /**
     * @param StorageUrlConverterInterface[] $converters
     *
     * @psalm-suppress InvalidAttribute
     */
    public function __construct(
        #[TaggedIterator('app.storage_url_converter')] private readonly iterable $converters
    ) {
    }

    public function getPublicUrl(File $file): string
    {
        if (!($storageMetadata = $file->getStorageMetadata())) {
            throw new \LogicException('Should never happened, storage metadata of file is null');
        }

        return $this->getConverter($storageMetadata)->getPublicUrl($file);
    }

    protected function getConverter(AbstractStorageMetadata $storageMetadata): StorageUrlConverterInterface
    {
        foreach ($this->converters as $converter) {
            if ($converter->support($storageMetadata)) {
                return $converter;
            }
        }

        throw new NoStorageUrlConverterFoundException('Aucun StorageUrlConverter trouvé pour '.get_class($storageMetadata));
    }
}
