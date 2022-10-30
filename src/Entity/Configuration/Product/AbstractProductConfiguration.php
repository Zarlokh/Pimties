<?php

namespace App\Entity\Configuration\Product;

use App\Utils\Traits\EntityIdTrait;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\Table;

#[Entity]
#[Table(name: 'product_configuration')]
#[InheritanceType('SINGLE_TABLE')]
#[DiscriminatorColumn(name: 'type', type: 'string', length: 20)]
#[DiscriminatorMap(['new' => NewProductConfiguration::class, 'second-hand' => SecondHandProductConfiguration::class])]
abstract class AbstractProductConfiguration
{
    use EntityIdTrait;

    #[Column(type: 'float')]
    protected float $warrantyTime = 1;

    public function getWarrantyTime(): float
    {
        return $this->warrantyTime;
    }

    public function setWarrantyTime(float $warrantyTime): self
    {
        $this->warrantyTime = $warrantyTime;

        return $this;
    }
}
