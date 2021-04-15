<?php

namespace Catalog\Domain\Service;

use Catalog\Domain\Entity\Item;
use Catalog\Domain\Entity\PricingRule;

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