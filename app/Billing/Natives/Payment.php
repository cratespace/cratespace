<?php

namespace App\Billing\Natives;

use App\Support\Money;
use App\Contracts\Billing\Payment as PaymentContract;

class Payment implements PaymentContract
{
    /**
     * The payment amount.
     *
     * @var int
     */
    protected $amount;

    /**
     * Indicates whether the payment was successfully processed.
     *
     * @var bool
     */
    protected $successful = false;

    /**
     * Create new native payment instance.
     *
     * @param int $amount
     *
     * @return void
     */
    public function __construct(int $amount)
    {
        $this->amount = $amount;
    }

    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return Money::format($this->amount);
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return $this->amount;
    }

    /**
     * Determine if the payment was successfully completed.
     *
     * @return bool
     */
    public function paid(): bool
    {
        return $this->successful;
    }

    /**
     * Set payment status.
     *
     * @param bool $yes
     *
     * @return void
     */
    public function wasSuccessful(bool $yes = false): void
    {
        $this->successful = $yes;
    }

    /**
     * Cancel payment.
     *
     * @return void
     */
    public function cancel(): void
    {
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
    }
}
