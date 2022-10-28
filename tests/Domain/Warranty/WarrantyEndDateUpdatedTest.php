<?php

namespace App\Tests\Domain\Warranty;

use App\Domain\Warranty\WarrantyDefaultValuesUpdater;
use App\Entity\Configuration\NewProductConfiguration;
use App\Entity\Warranty;
use App\Strategy\ProductConfigurationStrategy;
use App\Tests\AbstractTestCase;
use App\Utils\DateTimeUtils;

class WarrantyEndDateUpdatedTest extends AbstractTestCase
{
    public function testEndDateIsNotNull(): void
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
            ->setWarrantyTime(2)
        ;

        $updater = $this->createWarrantyEndDateUpdater();

        $updater->update($warranty);

        $this->assertNotNull($warranty->getEndDate());
    }

    private function createWarrantyEndDateUpdater(): WarrantyDefaultValuesUpdater
    {
        $productConfigurationStrategy = $this->createConfiguredMock(ProductConfigurationStrategy::class, [
           'getProductConfigurationForWarranty' => (new NewProductConfiguration())->setWarrantyTime(2)
        ]);

        return new WarrantyDefaultValuesUpdater(new DateTimeUtils(), $productConfigurationStrategy);
    }

    public function testWithWarrantyTimeExtended(): void
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
            ->setWarrantyTime(5)
        ;

        $updater = $this->createWarrantyEndDateUpdater();

        $updater->update($warranty);

        $this->assertEquals('2025-10-27', $warranty->getEndDate()->format('Y-m-d'));
    }

    public function testWithFloatExtendedWarranty(): void
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
            ->setWarrantyTime(2.5)
        ;

        $updater = $this->createWarrantyEndDateUpdater();

        $updater->update($warranty);

        $this->assertEquals('2023-04-27', $warranty->getEndDate()->format('Y-m-d'));
    }

    public function testWithNullWarrantyTime()
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
        ;

        $updater = $this->createWarrantyEndDateUpdater();

        $updater->update($warranty);

        $this->assertEquals('2022-10-27', $warranty->getEndDate()->format('Y-m-d'));
    }
}