<?php

namespace App\Processes\Orders\Concerns;

use Facades\App\Calculators\Purchase;

trait CalculatesPrices
{
    /**
     * Calculates total prices with all relevant charges applied.
     *
     * @param  float $resourcePrice
     * @return array
     */
    protected function calculate(float $resourcePrice)
    {
        cache()->put(
            'prices',
            $prices = Purchase::calculate($resourcePrice)->getAmounts()
        );

        return $prices;
    }
}
