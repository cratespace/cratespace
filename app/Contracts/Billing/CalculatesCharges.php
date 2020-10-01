<?php

namespace App\Contracts\Billing;

use App\Contracts\Models\Priceable;

interface CalculatesCharges
{
    /**
     * Calculate relevant charges of given resource.
     *
     * @param \App\Contracts\Models\Priceable $resource
     *
     * @return array
     */
    public function calculate(Priceable $resource): array;
}
