<?php

namespace App\Calculators\Charges;

use App\Contracts\Charge as ChargeContract;

class Subtotal implements ChargeContract
{
    /**
     * {@inheritdoc}
     */
    public function apply(int $price)
    {
        return $price;
    }
}
