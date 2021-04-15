<?php

namespace Catalog\Domain\Entity;

class PricingRule
{
    public function __construct(
        private Item $item,
        private int $count,
        private float $price,
    ) {}
}