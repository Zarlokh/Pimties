<?php

namespace App\Command\Cron;

use App\Factory\DateTimeFactory;
use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\Console\Command\Command;

abstract class AbstractCronCommand extends Command implements CronInterface
{
    /** @var string[] */
    private array $dateTimePatterns = [];

    protected function addDateTimePattern(string $dateTimePattern): self
    {
        $this->dateTimePatterns[] = $dateTimePattern;

        return $this;
    }

    private function hasDateTimePattern(): bool
    {
        return count($this->dateTimePatterns) > 0;
    }

    private function evaluateDateTimePattern(\DateTimeImmutable $now): bool
    {
        foreach ($this->dateTimePatterns as $dateTimePattern) {
            $matches = null;

            if (!preg_match('/^(\d{4}|\*)\-(\d{2}|\*)\-(\d{2}|\*) (\d{2}|\*):(\d{2}|\*)$/', $dateTimePattern, $matches)) {
                throw new InvalidConfigurationException('Bad DateTime pattern for cron '.($this->getName() ?? 'no name').': '.$dateTimePattern);
            }
            $year = '*' === $matches[1] ? $now->format('Y') : $matches[1];
            $month = '*' === $matches[2] ? $now->format('m') : $matches[2];
            $day = '*' === $matches[3] ? $now->format('d') : $matches[3];
            $hour = '*' === $matches[4] ? $now->format('H') : $matches[4];
            $minute = '*' === $matches[5] ? $now->format('i') : $matches[5];

            $dateCandidate = \DateTime::createFromFormat('Y-m-d H:i:s', $year.'-'.$month.'-'.$day.' '.$hour.':'.$minute.':00');

            if ($now->getTimestamp() >= $dateCandidate->getTimestamp()) {
                return true;
            }
        }

        return false;
    }

    public function shouldBeScheduled(): bool
    {
        return $this->hasDateTimePattern() && $this->evaluateDateTimePattern(DateTimeFactory::createNow());
    }
}
