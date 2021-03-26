<?php

namespace App\Models\Concerns;

use Carbon\Carbon;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use App\Contracts\Billing\Order;
use App\Services\Stripe\Customer;
use App\Contracts\Billing\Payment;
use Illuminate\Database\Eloquent\Relations\HasOne;

trait ManagesProduct
{
    /**
     * Get the owner of the product.
     *
     * @return mixed
     */
    public function merchant()
    {
        return $this->user;
    }

    /**
     * Get the order details of the space.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function order(): HasOne
    {
        return $this->hasOne(Order::class, 'product_id');
    }

    /**
     * Reserve product for customer.
     *
     * @return void
     */
    public function reserve(): void
    {
        $this->update(['reserved_at' => now()]);

        ProductReserved::dispatch($this);
    }

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void
    {
        $this->update(['reserved_at' => null]);

        ProductReleased::dispatch($this);
    }

    /**
     * Get full price of product in integer value.
     *
     * @return int
     */
    public function fullPrice(): int
    {
        return $this->price + ($this->tax ?? 0);
    }

    /**
     * Place an order for the product.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Contracts\Billing\Order
     */
    public function placeOrder(Payment $payment): Order
    {
        $this->reserve();

        $order = $this->order()->create([
            'user_id' => $this->merchant()->id,
            'customer_id' => Customer::native($payment->customer)->id,
            'amount' => $payment->amount(),
            'details' => $payment->toArray(),
        ]);

        return $order;
    }

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool
    {
        if ($this->departs_at->isBefore(Carbon::now())) {
            return ! is_null($this->reserved_at) || $this->order()->exists();
        }
    }
}