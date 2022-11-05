<?php

namespace App\Warranty;

interface ExpiredWarrantySchedulerInterface
{
    public function scheduleExpiredWarranty(): void;
}
