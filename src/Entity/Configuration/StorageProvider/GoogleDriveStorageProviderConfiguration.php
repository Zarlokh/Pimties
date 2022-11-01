<?php

namespace App\Entity\Configuration\StorageProvider;

use App\Utils\Traits\AllChildOnSameCrudControllerTrait;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class GoogleDriveStorageProviderConfiguration extends AbstractStorageProviderConfiguration
{
    use AllChildOnSameCrudControllerTrait;
}
