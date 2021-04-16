<?php

namespace Catalog\Application;

class DuplicateRulesException extends \Exception
{
    const MESSAGE = 'PricingRules contains duplicates for SKU: "%s" and Count: "%s")';

    public function __construct(string $sku, int $count)
    {
        parent::__construct(
            sprintf(
                self::MESSAGE,
                $sku,
                $count
            )
        );
    }
}