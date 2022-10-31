<?php

namespace App\Tests;

trait ReflectionTrait
{
    protected function callNotAccessibleMethods(object $objectToCallMethods, string $method, ... $args): mixed
    {
        $ref = new \ReflectionMethod($objectToCallMethods, $method);
        $ref->setAccessible(true);

        return $ref->invoke($objectToCallMethods, ... $args);
    }
}