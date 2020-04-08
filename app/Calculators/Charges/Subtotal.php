<?php

namespace App\Calculators\Charges;

use App\Contracts\Charge as ChargeContract;

class Subtotal implements ChargeContract
{
    /**
     * {@inheritdoc}
     */
    public function apply(float $price)
    {
        return $price;
    }
}
