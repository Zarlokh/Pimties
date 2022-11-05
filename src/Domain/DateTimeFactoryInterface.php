<?php

namespace App\Domain;

interface DateTimeFactoryInterface
{
    public static function createNow(): \DateTimeImmutable;
}
