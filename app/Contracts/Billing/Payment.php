<?php

namespace App\Contracts\Billing;

interface Payment
{
    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string;

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int;

    /**
     * Validate if the payment intent was successful and throw an exception if not.
     *
     * @return void
     *
     * @throws \App\Exceptions\PaymentFailedException
     * @throws \App\Exceptions\PaymentFailure
     */
    public function validate(): void;
}
