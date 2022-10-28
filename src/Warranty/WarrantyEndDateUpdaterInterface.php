<?php

namespace App\Warranty;

use App\Entity\Warranty;

interface WarrantyEndDateUpdaterInterface
{
    public function update(Warranty $warranty): void;
}
