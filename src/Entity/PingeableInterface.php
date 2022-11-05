<?php

namespace App\Entity;

interface PingeableInterface
{
    public function getId(): ?int;

    public function setPingedAt(\DateTimeImmutable $pingedAt): self;
}
