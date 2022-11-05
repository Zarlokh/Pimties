<?php

namespace App\Entity;

use App\Entity\File\File;
use App\Factory\DateTimeFactory;
use App\Repository\WarrantyRepository;
use App\Utils\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\OneToOne;
use Symfony\Component\Validator\Constraints\NotBlank;

#[Entity(repositoryClass: WarrantyRepository::class)]
class Warranty implements PingeableInterface, HasFileInterface
{
    use EntityIdTrait;

    public const SECOND_HAND_PRODUCT = 0;
    public const NEW_PRODUCT = 1;

    #[Column(type: 'string', length: 30)]
    #[NotBlank]
    private ?string $name = null;

    #[Column(type: 'date_immutable')]
    #[NotBlank]
    private \DateTimeImmutable $startDate;

    #[Column(type: 'date_immutable')]
    private ?\DateTimeImmutable $endDate = null;

    #[Column(type: 'float', nullable: true)]
    private ?float $extendedWarrantyTime = null;

    #[Column(type: 'boolean')]
    private bool $isSecondHandProduct = false;

    #[Column(type: 'boolean')]
    private bool $hasExtendedWarrantyTime = false;

    #[OneToOne(targetEntity: File::class, cascade: ['all'], orphanRemoval: true)]
    #[JoinColumn(name: 'file_id', referencedColumnName: 'id')]
    private File $file;

    #[Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $pingPlannedAt = null;

    #[Column(type: 'date_immutable', nullable: true)]
    private ?\DateTimeImmutable $pingedAt = null;

    public function __construct()
    {
        $this->startDate = DateTimeFactory::createNow();
        $this->file = new File();
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

    public function getExtendedWarrantyTime(): ?float
    {
        return $this->extendedWarrantyTime;
    }

    public function setExtendedWarrantyTime(?float $extendedWarranty): self
    {
        $this->extendedWarrantyTime = $extendedWarranty;

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

    public function calculateWarrantyTime(): int
    {
        if (!$this->endDate) {
            return 0;
        }

        return date_diff($this->startDate, $this->endDate)->y;
    }

    public function hasExtendedWarrantyTime(): bool
    {
        return $this->hasExtendedWarrantyTime;
    }

    public function setHasExtendedWarrantyTime(bool $hasExtendedWarrantyTime): self
    {
        $this->hasExtendedWarrantyTime = $hasExtendedWarrantyTime;

        return $this;
    }

    public function getFile(): File
    {
        return $this->file;
    }

    public function setFile(File $file): self
    {
        $this->file = $file;

        return $this;
    }

    public function getPingPlannedAt(): ?\DateTimeImmutable
    {
        return $this->pingPlannedAt;
    }

    public function setPingPlannedAt(?\DateTimeImmutable $pingPlannedAt): self
    {
        $this->pingPlannedAt = $pingPlannedAt;

        return $this;
    }

    public function getPingedAt(): ?\DateTimeImmutable
    {
        return $this->pingedAt;
    }

    public function setPingedAt(\DateTimeImmutable $pingedAt): self
    {
        $this->pingedAt = $pingedAt;

        return $this;
    }
}
