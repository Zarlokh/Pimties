<?php

namespace App\Admin\FieldProvider;

interface FieldProviderInterface
{
    public function supports(object $instance): bool;

    public function getFields(): array;
}
