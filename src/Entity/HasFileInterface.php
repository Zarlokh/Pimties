<?php

namespace App\Entity;

use App\Entity\File\File;

interface HasFileInterface
{
    public function getFile(): File;
}
