<?php

namespace App\Twig;

use App\Entity\File\File;
use App\Storage\StorageUrlConverter;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class StorageProviderExtension extends AbstractExtension
{
    public function __construct(private readonly StorageUrlConverter $storageUrlConverter)
    {
    }

    public function getFilters()
    {
        return [
            new TwigFilter('convert_to_public_url', [$this, 'convertToPublicUrl']),
        ];
    }

    public function convertToPublicUrl(File $file): string
    {
        return $this->storageUrlConverter->getPublicUrl($file);
    }
}
