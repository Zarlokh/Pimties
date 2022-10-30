<?php

namespace App\Tests\Domain\Warranty;

use App\Domain\Warranty\WarrantyCalculatedValuesUpdater;
use App\Entity\Configuration\Product\NewProductConfiguration;
use App\Entity\Warranty;
use App\ProductConfiguration\ProductConfigurationStrategy;
use App\Tests\AbstractTestCase;
use App\Utils\DateTimeUtils;

class WarrantyCalculatedValuesUpdaterTest extends AbstractTestCase
{
    public function testEndDateIsNotNull(): void
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
            ->setHasExtendedWarrantyTime(true)
            ->setExtendedWarrantyTime(1)
        ;

        $updater = $this->createWarrantyCalculatedValuesUpdater();

        $updater->update($warranty);

        $this->assertNotNull($warranty->getEndDate());
    }

    private function createWarrantyCalculatedValuesUpdater(): WarrantyCalculatedValuesUpdater
    {
        $productConfigurationStrategy = $this->createConfiguredMock(ProductConfigurationStrategy::class, [
           'getProductConfigurationForWarranty' => (new NewProductConfiguration())->setWarrantyTime(2)
        ]);

        return new WarrantyCalculatedValuesUpdater(new DateTimeUtils(), $productConfigurationStrategy);
    }

    public function testWithWarrantyTimeExtended(): void
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
            ->setHasExtendedWarrantyTime(true)
            ->setExtendedWarrantyTime(5)
        ;

        $updater = $this->createWarrantyCalculatedValuesUpdater();

        $updater->update($warranty);

        $this->assertEquals('2025-10-27', $warranty->getEndDate()->format('Y-m-d'));
    }

    public function testWithFloatExtendedWarranty(): void
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
            ->setHasExtendedWarrantyTime(true)
            ->setExtendedWarrantyTime(2.5)
        ;

        $updater = $this->createWarrantyCalculatedValuesUpdater();

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

        $updater = $this->createWarrantyCalculatedValuesUpdater();

        $updater->update($warranty);

        $this->assertEquals('2022-10-27', $warranty->getEndDate()->format('Y-m-d'));
    }

    public function testMultipleSetWarrantyTime()
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
        ;

        $updater = $this->createWarrantyCalculatedValuesUpdater();

        $updater->update($warranty);

        $this->assertEquals('2022-10-27', $warranty->getEndDate()->format('Y-m-d'));

        $warranty
            ->setHasExtendedWarrantyTime(true)
            ->setExtendedWarrantyTime(8)
        ;


        $updater->update($warranty);
        $this->assertEquals('2028-10-27', $warranty->getEndDate()->format('Y-m-d'));

        $warranty->setHasExtendedWarrantyTime(false);

        $updater->update($warranty);
        $this->assertNull($warranty->getExtendedWarrantyTime());
        $this->assertEquals('2022-10-27', $warranty->getEndDate()->format('Y-m-d'));

        $warranty
            ->setHasExtendedWarrantyTime(true)
            ->setExtendedWarrantyTime(5)
        ;

        $updater->update($warranty);
        $this->assertEquals('2025-10-27', $warranty->getEndDate()->format('Y-m-d'));
        $warranty->setExtendedWarrantyTime(24);

        $updater->update($warranty);
        $this->assertEquals('2044-10-27', $warranty->getEndDate()->format('Y-m-d'));
    }

    public function testUpdateStartDate()
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
        ;

        $updater = $this->createWarrantyCalculatedValuesUpdater();

        $updater->update($warranty);

        $this->assertEquals('2022-10-27', $warranty->getEndDate()->format('Y-m-d'));

        $warranty->setStartDate(new \DateTimeImmutable('2023-10-27'));

        $updater->update($warranty);
        $this->assertEquals('2025-10-27', $warranty->getEndDate()->format('Y-m-d'));
    }

    public function testExtendedWarrantyTimeNotUsedIfHasserNotSetToTrue()
    {
        $warranty = new Warranty();
        $warranty
            ->setName('name')
            ->setStartDate(new \DateTimeImmutable('2020-10-27'))
            ->setExtendedWarrantyTime(15)
        ;

        $updater = $this->createWarrantyCalculatedValuesUpdater();

        $updater->update($warranty);

        $this->assertEquals('2022-10-27', $warranty->getEndDate()->format('Y-m-d'));
    }
}