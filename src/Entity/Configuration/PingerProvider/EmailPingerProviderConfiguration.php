<?php

namespace App\Entity\Configuration\PingerProvider;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class EmailPingerProviderConfiguration extends AbstractPingerProviderProviderConfiguration
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
}
