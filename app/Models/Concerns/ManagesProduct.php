<?php

namespace App\Models\Concerns;

use Carbon\Carbon;
use App\Events\OrderPlaced;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use App\Contracts\Billing\Order;
use App\Services\Stripe\Customer;
use App\Contracts\Billing\Payment;

trait ManagesProduct
{
    /**
     * The unique code used to identify the product.
     *
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * Get the owner of the product.
     *
     * @return mixed
     */
    public function merchant()
    {
        return $this->owner;
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
     * Get full amount inclusive of tax for product in integer value.
     *
     * @return int
     */
    public function fullAmount(): int
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
            'amount' => $payment->rawAmount(),
            'payment' => $payment->id,
        ]);

        OrderPlaced::dispatch($order);

        return $order;
    }

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool
    {
        if ($this->departs_at->isAfter(Carbon::now())) {
            return is_null($this->reserved_at) && ! $this->order()->exists();
        }

        return false;
    }

    /**
     * Determine if the product is nearing it's expiration.
     *
     * @return bool
     */
    public function nearingExpiration(): bool
    {
        return $this->schedule->nearingDeparture();
    }

    /**
     * Get the details regarding the product.
     *
     * @return array
     */
    public function details(): array
    {
        return array_merge($this->toArray(), [
            'key' => $this->getTable(),
        ]);
    }

    /**
     * Get the order associated with the product.
     *
     * @return \App\Contracts\Billing\Order
     */
    public function getOrderDetails(): Order
    {
        return $this->order;
    }
}
