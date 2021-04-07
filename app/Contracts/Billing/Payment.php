<?php

namespace App\Contracts\Billing;

use Illuminate\Contracts\Support\Arrayable;

interface Payment extends Payable, Arrayable
{
    /**
     * Determine if the payment was successfully completed.
     *
     * @return bool
     */
    public function paid(): bool;
}
