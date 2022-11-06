<?php

namespace App\Admin\FieldProvider;

use App\Entity\Configuration\PingerProvider\PingerProviderConfigurationInterface;

interface FieldProviderInterface
{
    public function supports(PingerProviderConfigurationInterface $instance): bool;

    public function getFields(): array;
}
