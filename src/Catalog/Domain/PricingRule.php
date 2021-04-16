<?php

namespace Catalog\Domain;

class PricingRule
{
    public function __construct(
        private Item $item,
        private int $count,
        private float $price,
    ) {}

    public function getItem(): Item
    {
        return $this->item;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}