<?php

namespace Catalog\Domain;

class Item
{
    public function __construct(
        private string $sku,
        private float $price,
    ) {}

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}