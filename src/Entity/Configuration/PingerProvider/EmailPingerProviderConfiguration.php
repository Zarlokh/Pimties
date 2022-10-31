<?php

namespace App\Entity\Configuration\PingerProvider;

use App\Utils\ClassUtils;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Translation\TranslatableMessage;

#[Entity]
class EmailPingerProviderConfiguration extends AbstractPingerProviderConfiguration
{
    #[Column(type: 'string', length: 100)]
    private ?string $email = null;

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getAdminListName(): string|TranslatableMessage
    {
        return new TranslatableMessage(sprintf('%s.%s', ClassUtils::getOnlyClassSnakeCase(parent::class), ClassUtils::getOnlyClassSnakeCase($this::class)), ['%email%' => $this->email ?? 'no email']);
    }
}
