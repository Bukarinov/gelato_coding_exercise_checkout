<?php

namespace Unit\Catalog\Domain;

use Catalog\Domain\Item;
use Catalog\Domain\PricingRule;
use PHPUnit\Framework\TestCase;

class PricingRuleTest extends TestCase
{
    public function test_GivenSkuAndCountAndPrice_ObjectIsCreatedSuccessfully()
    {
        $pricingRule = new PricingRule(sku: 'A', count: 2, price: 42.0);

        $this->assertInstanceOf(
            PricingRule::class,
            $pricingRule
        );

        $this->assertEquals(
            'A',
            $pricingRule->getSku()
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

    public function test_GivenSkuOnly_ThrownException()
    {
        $this->expectException(\ArgumentCountError::class);

        new PricingRule(sku: 'A');
    }

    public function test_GivenCountOnly_ThrownException()
    {
        $this->expectException(\ArgumentCountError::class);

        new PricingRule(count: 2);
    }

    public function test_GivenPriceOnly_ThrownException()
    {
        $this->expectException(\ArgumentCountError::class);

        new PricingRule(price: 42.0);
    }
}
