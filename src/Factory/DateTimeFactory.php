<?php

namespace App\Factory;

use App\Domain\DateTimeFactoryInterface;

class DateTimeFactory implements DateTimeFactoryInterface
{
    public static function createNow(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
