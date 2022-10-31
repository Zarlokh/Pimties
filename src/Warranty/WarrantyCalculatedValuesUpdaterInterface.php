<?php

namespace App\Warranty;

use App\Entity\Warranty;

interface WarrantyCalculatedValuesUpdaterInterface
{
    public function update(Warranty $warranty): void;
}
