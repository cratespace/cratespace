<?php

namespace App\Processes\Orders\Concerns;

use Facades\App\Calculators\Purchase;

trait CalculatesPrices
{
    /**
     * [calculate description]
     * @param  [type] $resourcePrice [description]
     * @return [type]                [description]
     */
    protected function calculate($resourcePrice)
    {
        $prices = array_merge(
            $prices = Purchase::calculate($resourcePrice)->getAmounts(),
            ['credit' => $prices['subtotal'] + $prices['tax']]
        );

        cache()->put('prices', $prices);

        return $prices;
    }
}
