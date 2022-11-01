<?php

namespace App\Entity\Configuration\StorageProvider;

use App\Utils\Traits\AllChildOnSameCrudControllerTrait;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class FileSystemStorageProviderConfiguration extends AbstractStorageProviderConfiguration
{
    use AllChildOnSameCrudControllerTrait;
}
