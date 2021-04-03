<?php

namespace Tests\Fixtures;

use Mockery as m;
use App\Models\User;
use App\Contracts\Billing\Order;
use App\Contracts\Billing\Payment;
use App\Contracts\Billing\Product;
use Illuminate\Support\Facades\Crypt;
use App\Exceptions\InvalidProductException;

class MockProduct implements Product
{
    /**
     * Mock product ID.
     *
     * @var int
     */
    protected $id = 1;

    /**
     * Datetime stamp indicating whether this product has been reserved.
     *
     * @var datetime|null
     */
    protected $reservedAt;

    /**
     * The product order instance.
     *
     * @var \App\Contracts\Billing\Order
     */
    protected $order;

    /**
     * Create new instance of product.
     *
     * @param int $id
     *
     * @return void
     */
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    /**
     * The unique code used to identify the product.
     *
     * @return string
     */
    public function code(): string
    {
        return Crypt::encryptString(
            get_class($this) . '-' . $this->id
        );
    }

    /**
     * Get the owner of the product.
     *
     * @return mixed
     */
    public function merchant()
    {
        return User::factory()->asBusiness()->create();
    }

    /**
     * Reserve product for customer.
     *
     * @return void
     */
    public function reserve(): void
    {
        $this->reservedAt = now();
    }

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void
    {
        $this->reservedAt = null;
    }

    /**
     * Get full amount inclusive of tax for product in integer value.
     *
     * @return int
     */
    public function fullAmount(): int
    {
        return 1000;
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
        $order = m::mock(Order::class);

        $order->payment = $payment;

        return $this->order = $order;
    }

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool
    {
        return is_null($this->reservedAt);
    }

    /**
     * Get the details regarding the product.
     *
     * @return array
     */
    public function details(): array
    {
        return [
            'merchant' => $this->merchant()->id,
            'id' => $this->id,
            'amount' => $this->fullAmount(),
        ];
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

    /**
     * Determine if the product is nearing it's expiration.
     *
     * @return bool
     */
    public function nearingExpiration(): bool
    {
        return false;
    }

    /**
     * Get the product belonging to the given ID.
     *
     * @param string|int $id
     *
     * @return \App\Contracts\Billing\Product
     */
    public function get($id): Product
    {
        if ($this->id === $id) {
            return $this;
        }

        throw new InvalidProductException("Product with ID {$id} was not found");
    }
}
