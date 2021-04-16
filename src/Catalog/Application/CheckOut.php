<?php

namespace Catalog\Application;

use Catalog\Domain\Item;
use Catalog\Domain\PricingRule;

class CheckOut
{
    /**
     * @var array
     */
    private array $pricingRulesHashMap = [];

    /**
     * @var array
     */
    private array $itemsHashMap = [];

    /**
     * @param PricingRule ...$pricingRules
     * @throws DuplicateRulesException
     */
    public function __construct(PricingRule ...$pricingRules)
    {
        $this->pricingRulesHashMap = self::createPricingRulesHashMap(...$pricingRules);
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
                /* @var PricingRule $pricingRule */
                $pricingRule = $this->pricingRulesHashMap[$sku][$sameItemsCount];
                $total += $pricingRule->getPrice();
            } else {
                // @TODO What a shame! Fix it by using collection object
                $item = $items[0];
                $total += $sameItemsCount * $item->getPrice();
            }
        }

        return $total;
    }

    /**
     * @param PricingRule ...$pricingRules
     * @return array
     * @throws DuplicateRulesException
     */
    static private function createPricingRulesHashMap(PricingRule ...$pricingRules): array
    {
        $pricingRulesHashMap = [];

        foreach ($pricingRules as $pricingRule) {
            $sku = $pricingRule->getItem()->getSku();
            $count = $pricingRule->getCount();

            if (isset($pricingRulesHashMap[$sku][$count])) {
                throw new DuplicateRulesException($sku, $count);
            }

            $pricingRulesHashMap[$sku][$count] = $pricingRule;
        }

        return $pricingRulesHashMap;
    }
}