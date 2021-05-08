<?php

namespace App\Products\Line;

use Carbon\Carbon;
use App\Support\Money;
use App\Events\OrderPlaced;
use App\Models\Space as Model;
use App\Contracts\Orders\Order;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use App\Services\Stripe\Customer;
use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;

class Space extends Model implements Product
{
    /**
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return Money::format($this->rawAmount());
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        $tax = 0;

        if (! is_null($this->tax)) {
            $tax += $this->tax;
        } elseif (isset($this->options['tax'])) {
            $tax += $this->options['tax'];
        }

        return $this->price + $tax;
    }

    /**
     * Get the product name.
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->id;
    }

    /**
     * The unique code used to identify the product.
     *
     * @param string $code
     *
     * @return void
     */
    public function setCode(string $code): void
    {
        $this->forceFill(['code' => $code])->save();
    }

    /**
     * The unique code used to identify the product.
     *
     * @return string
     */
    public function getCode(): string
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
        $this->forceFill(['reserved_at' => now()])->save();

        ProductReserved::dispatch($this);
    }

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void
    {
        $this->forceFill(['reserved_at' => null])->save();

        ProductReleased::dispatch($this);
    }

    /**
     * Place an order for the product.
     *
     * @param \App\Contracts\Billing\Payment $payment
     *
     * @return \App\Contracts\Orders\Order
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
        if (! $this->expired() && ! $this->nearingExpiration()) {
            return ! $this->reserved();
        }

        return false;
    }

    /**
     * Determine if the product has expired.
     *
     * @return bool
     */
    public function expired(): bool
    {
        return $this->departs_at->isBefore(Carbon::now());
    }

    /**
     * Determine if the space is reserved.
     *
     * @return bool
     */
    public function reserved(): bool
    {
        return ! is_null($this->reserved_at) || $this->order()->exists();
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
     * Determine if the given code matches the product's unique code.
     *
     * @param string $code
     *
     * @return \App\Contracts\Products\Product|bool
     */
    public function match(string $code)
    {
        if ($this->getCode() === $code) {
            return $this;
        }

        return false;
    }
}
