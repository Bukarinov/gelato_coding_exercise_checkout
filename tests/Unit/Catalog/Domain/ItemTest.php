<?php

namespace Unit\Catalog\Domain;

use Catalog\Domain\Item;
use PHPUnit\Framework\TestCase;

class ItemTest extends TestCase
{
    /** @test */
    public function construct_GivenSkuAndPrice_ObjectIsCreatedSuccessfully()
    {
        $item = new Item(sku: 'A', price: 45);

        $this->assertInstanceOf(
            Item::class,
            $item
        );
    }
}
