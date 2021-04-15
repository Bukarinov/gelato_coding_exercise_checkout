<?php

namespace Catalog\Domain;

class Item
{
    public function __construct(
        private string $sku,
        private float $price,
    ) {}
}