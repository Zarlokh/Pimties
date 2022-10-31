<?php

namespace App\Tests\Pinger;

use App\Entity\Configuration\PingerProvider\EmailPingerProviderConfiguration;
use App\Pinger\PingerFinder;
use App\Pinger\Provider\Email\EmailPingerProvider;
use App\Tests\AbstractKernelTestCase;

class PingerFinderTest extends AbstractKernelTestCase
{
    public function testGettingEmailPinger()
    {
        self::bootKernel();

        /** @var PingerFinder $pingerFinder */
        $pingerFinder = static::getContainer()->get(PingerFinder::class);

        $this->assertEquals(EmailPingerProvider::class, get_class($this->callNotAccessibleMethods($pingerFinder, 'getPingerByConfiguration', new EmailPingerProviderConfiguration())));
    }
}