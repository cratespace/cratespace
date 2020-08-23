<?php

namespace Tests\Concerns;

use App\Billing\Charges\Calculator;
use App\Contracts\Models\Priceable;
use Illuminate\Database\Eloquent\Model;

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
        $this->getCalculator($resource)->calculate();
    }

    /**
     * Get charge calculator instance.
     *
     * @param \Illuminate\Database\Eloquent\Model $resource
     *
     * @return \App\Contracts\Support\Calculator
     */
    public function getCalculator(Model $resource): Calculator
    {
        return new Calculator($resource);
    }
}
