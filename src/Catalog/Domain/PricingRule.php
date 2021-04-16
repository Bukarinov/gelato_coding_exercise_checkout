<?php

namespace Catalog\Domain;

class PricingRule
{
    public function __construct(
        private string $sku,
        private int $count,
        private float $price,
    ) {}

    public function getSku(): string
    {
        return $this->sku;
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