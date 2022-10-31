<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpKernel\KernelInterface;

abstract class AbstractKernelTestCase extends KernelTestCase
{
    use ReflectionTrait;


    protected static function bootKernel(array $options = []): KernelInterface
    {
        return parent::bootKernel(array_merge(['debug' => false], $options));
    }
}