<?php

namespace Catalog\Application;

use Catalog\Domain\Item;
use Catalog\Domain\PricingRule;

class CheckOut
{
    /**
     * @param PricingRule[]
     */
    private $pricingRules = [];

    public function __construct(PricingRule ...$pricingRules) {
        $this->pricingRules = $pricingRules;
    }

    public function scan(Item $item): self
    {

        return $this;
    }

    public function total(): float
    {

    }
}