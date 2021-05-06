<?php

namespace App\Contracts\Billing;

use App\Contracts\Support\Cancellable;
use Illuminate\Contracts\Support\Arrayable;

interface Payment extends Payable, Arrayable, Cancellable
{
    /**
     * Validate if the payment intent was successful and throw an exception if not.
     *
     * @return void
     *
     * @throws \App\Exceptions\PaymentActionRequired
     * @throws \App\Exceptions\PaymentFailure
     */
    public function validate(): void;

    /**
     * Determine if the payment was successful.
     *
     * @return bool
     */
    public function isSucceeded(): bool;

    /**
     * Determine if the payment was cancelled.
     *
     * @return bool
     */
    public function isCancelled(): bool;
}
