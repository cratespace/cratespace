<?php

namespace Tests\Concerns;

use App\Billing\Charges\Calculator;
use App\Contracts\Models\Priceable;

trait CalculatesCharges
{
    /**
     * Calculate charges using given resource.
     *
     * @param \App\Contracts\Models\Priceable $resource
     *
     * @return void
     */
    protected function calculateCharges(Priceable $resource)
    {
        $calculator = new Calculator();

        $calculator->setResource($resource);

        $calculator->calculate();
    }
}
