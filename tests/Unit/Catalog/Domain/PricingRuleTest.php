<?php

namespace Unit\Catalog\Domain;

use Catalog\Domain\Item;
use Catalog\Domain\PricingRule;
use PHPUnit\Framework\TestCase;

class PricingRuleTest extends TestCase
{
    public function test_GivenItemAndCountAndPrice_ObjectIsCreatedSuccessfully()
    {
        $item = $this->createMock(Item::class);
        $pricingRule = new PricingRule(item: $item, count: 2, price: 42.0);

        $this->assertInstanceOf(
            PricingRule::class,
            $pricingRule
        );

        $this->assertEquals(
            $item,
            $pricingRule->getItem()
        );

        $this->assertEquals(
            2,
            $pricingRule->getCount()
        );

        $this->assertEquals(
            42.0,
            $pricingRule->getPrice()
        );
    }

    public function test_GivenNothing_ThrownException()
    {
        $this->expectException(\ArgumentCountError::class);

        new PricingRule();
    }

    public function test_GivenItemOnly_ThrownException()
    {
        $item = $this->createMock(Item::class);

        $this->expectException(\ArgumentCountError::class);

        new PricingRule(item: $item);
    }

    public function test_GivenCountOnly_ThrownException()
    {
        $item = $this->createMock(Item::class);

        $this->expectException(\ArgumentCountError::class);

        new PricingRule(count: 2);
    }

    public function test_GivenPriceOnly_ThrownException()
    {
        $item = $this->createMock(Item::class);

        $this->expectException(\ArgumentCountError::class);

        new PricingRule(price: 42.0);
    }
}
