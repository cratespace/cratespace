<?php

namespace App\Calculators;

use App\Contracts\Calculator as CalculatorContract;

class Purchase implements CalculatorContract
{
    /**
     * All applicable charges to be calculated.
     *
     * @var array
     */
    protected $charges = [
        'subtotal' => \App\Calculators\Charges\Subtotal::class,
        'service' => \App\Calculators\Charges\Service::class,
        'tax' => \App\Calculators\Charges\Tax::class,
    ];

    /**
     * All charges and calculated amount for current purchase.
     *
     * @var array
     */
    protected $amounts = [];

    /**
     * {@inheritdoc}
     */
    public function calculate($price)
    {
        foreach ($this->getCharges() as $charge => $calculator) {
            $this->amounts[$charge] = resolve($calculator)->apply($price);
        }

        $this->amounts['total'] = array_sum($this->amounts);

        return $this->amounts['total'];
    }

    /**
     * Get all charges and amounts.
     *
     * @return array
     */
    public function getAmounts()
    {
        return $this->amounts;
    }

    /**
     * Get all applicable charges.
     *
     * @return array
     */
    public function getCharges()
    {
        return $this->charges;
    }
}
