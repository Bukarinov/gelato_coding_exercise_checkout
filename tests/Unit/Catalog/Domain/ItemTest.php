<?php

namespace Unit\Catalog\Domain;

use Catalog\Domain\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    public function test_GivenSkuAndPrice_ObjectIsCreatedSuccessfully()
    {
        $item = new Item(sku: 'A', price: 42);

        $this->assertInstanceOf(
            Item::class,
            $item
        );

        $this->assertEquals(
            'A',
            $item->getSku()
        );

        $this->assertEquals(
            42,
            $item->getPrice()
        );
    }

    public function test_GivenNothing_ThrownException()
    {
        $this->expectException(\ArgumentCountError::class);

        new Item();
    }

    public function test_GivenSkuOnly_ThrownException()
    {
        $this->expectException(\ArgumentCountError::class);

        new Item(sku: 'A');
    }

    public function test_GivenPriceOnly_ThrownException()
    {
        $this->expectException(\ArgumentCountError::class);

        new Item(price: 42);
    }
}
