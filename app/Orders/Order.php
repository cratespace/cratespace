<?php

namespace App\Orders;

use App\Support\Money;
use App\Events\OrderCancelled;
use App\Contracts\Products\Product;
use App\Facades\ConfirmationNumber;
use App\Models\Order as OrderModel;
use App\Contracts\Orders\Order as OrderContract;

class Order extends OrderModel implements OrderContract
{
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
        return true;
    }

    /**
     * Get the product associated with this order.
     *
     * @return \App\Contracts\Products\Product
     */
    public function product(): Product
    {
        return $this->orderable;
    }

    /**
     * Determine if the order has been cofirmed.
     *
     * @return bool
     */
    public function confirmed(): bool
    {
        if (! is_null($this->confirmation_number)) {
            return ConfirmationNumber::validate($this->confirmation_number);
        }

        return false;
    }

    /**
     * Confirm order for customer.
     *
     * @return void
     */
    public function confirm(): void
    {
        if (! is_null($this->confirmation_number)) {
            return;
        }

        $this->forceFill([
            'confirmation_number' => ConfirmationNumber::generate(),
        ])->saveQuietly();
    }

    /**
     * Cancel a course of action or a resource.
     *
     * @return void
     */
    public function cancel(): void
    {
        $this->product()->release();

        OrderCancelled::dispatch($this);

        $this->delete();
    }

    /**
     * Determine if the order can be cancelled.
     *
     * @return bool
     */
    public function canCancel(): bool
    {
        return ! $this->product()->nearingExpiration();
    }
}
