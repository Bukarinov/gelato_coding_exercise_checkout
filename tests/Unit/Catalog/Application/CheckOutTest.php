<?php

namespace Unit\Catalog\Application;

use Catalog\Application\CheckOut;
use Catalog\Application\DuplicateRulesException;
use Catalog\Domain\Item;
use Catalog\Domain\PricingRule;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class CheckOutTest extends TestCase
{
    public function test_ScanOneItemAndNoPricingRules_TotalAndItemPriceAreEqual()
    {
        $item = $this->createMockItem(sku: 'A', price: 50.0);

        $checkOut = new CheckOut();
        $checkOut->scan($item);

        $this->assertEquals(
            50.0,
            $checkOut->total()
        );
    }

    public function test_ScanSameItemsAndNoPricingRules_TotalAndItemsPricesAreEqual()
    {
        $item = $this->createMockItem(sku: 'A', price: 50.0);

        $checkOut = new CheckOut();
        $checkOut
            ->scan($item)
            ->scan($item)
        ;

        $this->assertEquals(
            100.0,
            $checkOut->total()
        );
    }

    public function test_ScanDifferentItemsAndNoPricingRules_TotalAndItemsPricesAreEqual()
    {
        $itemA = $this->createMockItem(sku: 'A', price: 50.0);
        $itemB = $this->createMockItem(sku: 'B', price: 30.0);

        $checkOut = new CheckOut();
        $checkOut
            ->scan($itemA)
            ->scan($itemB)
        ;

        $this->assertEquals(
            80.0,
            $checkOut->total()
        );
    }

    public function test_ScanSameItemsAndAddPricingRules_TotalAndPriceFromPricingRulesAreEqual()
    {
        $item = $this->createMockItem(sku: 'A', price: 50.0);
        $pricingRule = $this->createMockPricingRule(item: $item, count: 3, price: 130.0);

        $checkOut = new CheckOut($pricingRule);
        $checkOut
            ->scan($item)
            ->scan($item)
            ->scan($item)
        ;

        $this->assertEquals(
            130.0,
            $checkOut->total()
        );
    }

    public function test_ScanDifferentItemsAndAddPricingRules_TotalCalculatedByPricingRulesAndItemsPrices()
    {
        $itemA = $this->createMockItem(sku: 'A', price: 50.0);
        $itemB = $this->createMockItem(sku: 'B', price: 30.0);
        $itemC = $this->createMockItem(sku: 'C', price: 20.0);
        $itemD = $this->createMockItem(sku: 'D', price: 15.0);

        $pricingRuleA = $this->createMockPricingRule(item: $itemA, count: 3, price: 130.0);
        $pricingRuleB = $this->createMockPricingRule(item: $itemB, count: 2, price: 45.0);

        $checkOut = new CheckOut($pricingRuleA, $pricingRuleB);
        $checkOut
            ->scan($itemA)
            ->scan($itemB)
            ->scan($itemC)
            ->scan($itemA)
            ->scan($itemB)
            ->scan($itemD)
            ->scan($itemA)
            ->scan($itemC)
        ;

        $this->assertEquals(
            130.0 + 45.0 + 2 * 20.0 + 15.0,//$pricingRuleA + $pricingRuleB + 2 * $itemC + $itemD
            $checkOut->total()
        );
    }

    public function test_ScanTwoSameItemsAndAddSeveralPricingRules_TotalAndPriceFromAppropriatePricingRulesAreEqual()
    {
        $itemA = $this->createMockItem(sku: 'A', price: 50.0);

        $pricingRuleA1 = $this->createMockPricingRule(item: $itemA, count: 3, price: 130.0);
        $pricingRuleA2 = $this->createMockPricingRule(item: $itemA, count: 2, price: 90.0);

        $checkOut = new CheckOut($pricingRuleA1, $pricingRuleA2);
        $checkOut
            ->scan($itemA)
            ->scan($itemA)
        ;

        $this->assertEquals(
            90.0,
            $checkOut->total()
        );
    }

    public function test_ScanThreeSameItemsAndAddSeveralPricingRules_TotalAndPriceFromAppropriatePricingRulesAreEqual()
    {
        $itemA = $this->createMockItem(sku: 'A', price: 50.0);

        $pricingRuleA1 = $this->createMockPricingRule(item: $itemA, count: 3, price: 130.0);
        $pricingRuleA2 = $this->createMockPricingRule(item: $itemA, count: 2, price: 90.0);

        $checkOut = new CheckOut($pricingRuleA1, $pricingRuleA2);
        $checkOut
            ->scan($itemA)
            ->scan($itemA)
            ->scan($itemA)
        ;

        $this->assertEquals(
            130.0,
            $checkOut->total()
        );
    }

    public function test_AddDuplicatePricingRules_ThrownException()
    {
        $itemA = $this->createMockItem(sku: 'A', price: 50.0);

        $pricingRuleA1 = $this->createMockPricingRule(item: $itemA, count: 3, price: 130.0);
        $pricingRuleA2 = $this->createMockPricingRule(item: $itemA, count: 3, price: 90.0);

        $this->expectException(DuplicateRulesException::class);
        $this->expectExceptionMessage(sprintf(
            'PricingRules contains duplicates for SKU: "%s" and Count: "%s")',
            'A',
            3
        ));

        new CheckOut($pricingRuleA1, $pricingRuleA2);
    }

    private function createMockItem(string $sku, float $price): MockObject|Item
    {
        $item = $this->createMock(Item::class);
        $item->method('getSku')->willReturn($sku);
        $item->method('getPrice')->willReturn($price);

        return $item;
    }

    private function createMockPricingRule(Item $item, int $count, float $price): MockObject|PricingRule
    {
        $pricingRule = $this->createMock(PricingRule::class);
        $pricingRule->method('getItem')->willReturn($item);
        $pricingRule->method('getCount')->willReturn($count);
        $pricingRule->method('getPrice')->willReturn($price);

        return $pricingRule;
    }
}
