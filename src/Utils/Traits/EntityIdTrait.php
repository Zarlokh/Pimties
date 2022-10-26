<?php

namespace App\Utils\Traits;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;

trait EntityIdTrait
{
    #[Id]
    #[GeneratedValue]
    #[Column(type:"integer")]
    private ?int $id = null;

    public function getId(): ?int
    {
        return $this->id;
    }
}
