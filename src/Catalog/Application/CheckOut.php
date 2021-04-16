<?php

namespace Catalog\Application;

use Catalog\Domain\Item;
use Catalog\Domain\PricingRule;

class CheckOut
{
    /**
     * @param PricingRule[]
     */
    private array $pricingRules = [];

    /**
     * @var array
     */
    private array $pricingRulesHashMap = [];

    /**
     * @var array
     */
    private array $itemsHashMap = [];

    public function __construct(PricingRule ...$pricingRules)
    {
        $this->pricingRules = $pricingRules;
        $this->pricingRulesHashMap = self::createPricingRulesHashMap(...$pricingRules);
    }

    /**
     * @return PricingRule[]
     */
    public function getPricingRules(): array
    {
        return $this->pricingRules;
    }

    public function scan(Item $item): self
    {
        $this->itemsHashMap[$item->getSku()][] = $item;

        return $this;
    }

    public function total(): float
    {
        $total = 0.0;

        /* @var Item[] $items */
        foreach ($this->itemsHashMap as $sku => $items) {
            $sameItemsCount = count($items);

            if (isset($this->pricingRulesHashMap[$sku][$sameItemsCount])) {
                $total += $this->pricingRulesHashMap[$sku][$sameItemsCount];
            } else {
                // @TODO What a shame! Fix it by using collection object
                $item = $items[0];
                $total += $sameItemsCount * $item->getPrice();
            }
        }

        return $total;
    }

    static private function createPricingRulesHashMap(PricingRule ...$pricingRules): array
    {
        $pricingRulesHashMap = [];

        foreach ($pricingRules as $pricingRule) {
            $sku = $pricingRule->getItem()->getSku();
            $count = $pricingRule->getCount();

            $pricingRulesHashMap[$sku][$count] = $pricingRule->getPrice();
        }

        return $pricingRulesHashMap;
    }
}