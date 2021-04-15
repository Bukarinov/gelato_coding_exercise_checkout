<?php

namespace Catalog\Domain\Entity;

class Item
{
    public function __construct(
        private string $sku,
        private float $price,
    ) {}
}