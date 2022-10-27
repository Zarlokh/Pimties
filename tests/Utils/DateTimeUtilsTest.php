<?php

namespace App\Tests\Utils;

use App\Tests\AbstractTestCase;
use App\Utils\DateTimeUtils;

class DateTimeUtilsTest extends AbstractTestCase
{
    public function testAddIntYears(): void
    {
        $dateTime = new \DateTimeImmutable('2022-10-27 22:53:00');

        $this->assertEquals('2024-10-27 22:53:00', $this->createDateTimeUtils()->addYears($dateTime, 2)->format('Y-m-d H:i:s'));
    }

    public function testAddFloatYears(): void
    {
        $dateTime = new \DateTimeImmutable('2022-10-27 22:53:00');

        $this->assertEquals('2025-04-27 22:53:00', $this->createDateTimeUtils()->addYears($dateTime, 2.5)->format('Y-m-d H:i:s'));
        $this->assertEquals('2025-01-27 22:53:00', $this->createDateTimeUtils()->addYears($dateTime, 2.3)->format('Y-m-d H:i:s'));
        $this->assertEquals('2025-08-27 22:53:00', $this->createDateTimeUtils()->addYears($dateTime, 2.9)->format('Y-m-d H:i:s'));
    }

    protected function createDateTimeUtils(): DateTimeUtils
    {
        return new DateTimeUtils();
    }
}