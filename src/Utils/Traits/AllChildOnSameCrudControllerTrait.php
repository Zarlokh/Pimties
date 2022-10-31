<?php

namespace App\Utils\Traits;

use App\Utils\ClassUtils;
use Symfony\Component\Translation\TranslatableMessage;

trait AllChildOnSameCrudControllerTrait
{
    public function getAdminListName(): string|TranslatableMessage
    {
        return sprintf('%s.%s', ClassUtils::getOnlyClassSnakeCase(get_parent_class($this) ?: 'no_parent_class'), ClassUtils::getOnlyClassSnakeCase($this::class));
    }
}
