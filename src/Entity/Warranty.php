<?php

namespace App\Entity;

use App\Factory\DateTimeFactory;
use App\Utils\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;

#[Entity]
class Warranty
{
    use EntityIdTrait;

    public const SECOND_HAND_PRODUCT = 0;
    public const NEW_PRODUCT = 1;

    #[Column(type:"string", length: 30)]
    private ?string $name = null;

    #[Column(type: "date_immutable")]
    private \DateTimeImmutable $startDate;

    #[Column(type: "date_immutable")]
    private ?\DateTimeImmutable $endDate = null;

    #[Column(type: "float")]
    private ?float $warrantyTime = null;

    #[Column(type: 'boolean')]
    private bool $isSecondHandProduct = false;

    public function __construct()
    {
        $this->startDate = DateTimeFactory::createNow();
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeImmutable $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getWarrantyTime(): ?float
    {
        return $this->warrantyTime;
    }

    public function setWarrantyTime(?float $extendedWarranty): self
    {
        $this->warrantyTime = $extendedWarranty;

        return $this;
    }

    public function getStartDate(): \DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeImmutable $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function isSecondHandProduct(): bool
    {
        return $this->isSecondHandProduct;
    }

    public function setIsSecondHandProduct(bool $isSecondHandProduct): self
    {
        $this->isSecondHandProduct = $isSecondHandProduct;

        return $this;
    }
}
