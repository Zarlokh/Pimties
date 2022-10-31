<?php

namespace App\Entity\Configuration;

use Symfony\Component\Translation\TranslatableMessage;

interface AllChildOnSameCrudControllerInterface
{
    public function getId(): ?int;

    public function getAdminListName(): string|TranslatableMessage;
}
