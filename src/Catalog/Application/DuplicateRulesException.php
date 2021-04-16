<?php

namespace Catalog\Application;

use Catalog\Domain\PricingRule;

class DuplicateRulesException extends \Exception
{
    const MESSAGE = 'PricingRules contains duplicates for SKU: "%s" and Count: "%s")';

    public function __construct(PricingRule $pricingRule)
    {
        parent::__construct(
            sprintf(
                self::MESSAGE,
                $pricingRule->getSku(),
                $pricingRule->getCount()
            )
        );
    }
}