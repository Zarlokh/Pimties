<?php

namespace App\Factory;

class DateTimeFactory
{
    public static function createNow(): \DateTimeImmutable
    {
        return new \DateTimeImmutable();
    }
}
