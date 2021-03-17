<?php

namespace App\Contracts\Billing;

use Illuminate\Database\Eloquent\Model;

interface PaymentMethod
{
    /**
     * Get the Stripe model instance.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function owner(): Model;
}
