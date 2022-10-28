<?php

namespace App\Tests;

use PHPUnit\Framework\TestCase;

abstract class AbstractTestCase extends TestCase
{
    protected function callNotAccessibleMethods(object $objectToCallMethods, string $method, ... $args): mixed
    {
        $ref = new \ReflectionMethod($objectToCallMethods, $method);
        $ref->setAccessible(true);

        return $ref->invoke($objectToCallMethods, ... $args);
    }
}