<?php

namespace App\Billing\Actions;

use App\Support\Formatter;
use App\Contracts\Models\Priceable;
use App\Contracts\Support\Calculator;
use App\Contracts\Billing\CalculatesCharges;

class CalculateCharges implements CalculatesCharges
{
    /**
     * Array of calculated and usable charges.
     *
     * @var array
     */
    protected $charges = [];

    /**
     * Instance of resource charges calculator.
     *
     * @var \App\Contracts\Support\Calculator
     */
    protected $calculator;

    /**
     * Create new instance of charges calculator.
     *
     * @param \App\Contracts\Support\Calculator $calculator
     *
     * @return void
     */
    public function __construct(Calculator $calculator)
    {
        $this->calculator = $calculator;
    }

    /**
     * Calculate relevant charges of given resource.
     *
     * @param \App\Contracts\Models\Priceable $resource
     *
     * @return array
     */
    public function calculate(Priceable $resource): array
    {
        foreach ($this->getChargeAmounts($resource) as $name => $amount) {
            $this->charges[$name] = Formatter::money((int) $amount);
        }

        return $this->charges;
    }

    /**
     * Get relevant charge amounts.
     *
     * @param \App\Contracts\Support\Calculator $calculator
     * @param \App\Contracts\Models\Priceable   $resource
     *
     * @return array
     */
    protected function getChargeAmounts(Priceable $resource): array
    {
        return tap($this->calculator, function (Calculator $calculator) use ($resource) {
            return $calculator->setResource($resource)->calculate();
        })->amounts();
    }
}
