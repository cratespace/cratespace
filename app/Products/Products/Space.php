<?php

namespace App\Products\Products;

use Carbon\Carbon;
use App\Events\OrderPlaced;
use App\Contracts\Orders\Order;
use App\Events\ProductReleased;
use App\Events\ProductReserved;
use App\Models\Traits\Orderable;
use App\Services\Stripe\Customer;
use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;
use App\Models\Space as SpaceModel;
use App\Models\Traits\HasEncryptableCode;

class Space extends SpaceModel implements Product
{
    use Orderable;
    use HasEncryptableCode;

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
     * The name used to identify the product.
     *
     * @return string
     */
    public function name(): string
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
        $this->forceFill(['code' => $code])->saveQuietly();
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
        $this->update(['reserved_at' => Carbon::now()]);

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
        if (! $this->expired()) {
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
     * Get the details regarding the product.
     *
     * @return array
     */
    public function details(): array
    {
        return array_merge($this->toArray(), [
            'product_type' => $this->getTable(),
        ]);
    }
}