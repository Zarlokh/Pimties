<?php

namespace App\Utils;

class DateTimeUtils
{
    private const MONTHS_IN_ONE_YEAR = 12;

    public function addYears(\DateTimeImmutable $dateTime, float $years): \DateTimeImmutable
    {
        $intYears = (int) $years;
        $newDate = $dateTime->add(new \DateInterval("P${intYears}Y"));

        if ($intYears == $years) {
            return $newDate;
        }

        $months = (int) (($years - $intYears) * self::MONTHS_IN_ONE_YEAR);

        return $newDate->add(new \DateInterval("P${months}M"));
    }
}
