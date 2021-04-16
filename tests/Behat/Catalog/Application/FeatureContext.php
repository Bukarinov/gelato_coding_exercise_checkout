<?php

namespace Test\Behat\Catalog\Application;

use Behat\Behat\Context\Context;
use Catalog\Application\CheckOut;
use Catalog\Domain\Item;
use Catalog\Domain\PricingRule;
use PHPUnit\Framework\Assert;

class FeatureContext implements Context
{
    private CheckOut $checkOut;

    /**
     * @var Item[]
     */
    private array $items = [];

    /**
     * @var PricingRule[]
     */
    private array $pricingRules = [];

    /**
     * @Given there is a :sku, which costs $:price
     */
    public function thereIsAnItemWhichCostsPs($sku, $price)
    {
        $this->items[$sku] = new Item(sku: $sku, price: $price);
    }

    /**
     * @Given there is a pricing rule for :sku, which costs $:price for :count items
     */
    public function thereIsAPricingRuleWhichCostsPsForCountItems($sku, $price, $count)
    {
        $this->pricingRules[] = new PricingRule(sku: $sku, count: $count, price: $price);
    }

    /**
     * @When I scan the :sku
     */
    public function iScanTheItem($sku)
    {
        if (!isset($this->items[$sku])) {
            throw new \RuntimeException(sprintf(
                "Create a '%s' Item before",
                $sku
            ));
        }

        // @TODO Should've been initialized through the construct, but we need to pass $pricingRules somehow
        if (empty($this->checkOut)) {
            $this->checkOut = new CheckOut(...$this->pricingRules);
        }

        $this->checkOut->scan($this->items[$sku]);
    }

    /**
     * @Then the total should be $:price
     */
    public function theTotalShouldBePs($price)
    {
        Assert::assertSame(
            floatval($price),
            $this->checkOut->total()
        );
    }
}
