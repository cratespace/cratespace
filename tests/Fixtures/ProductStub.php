<?php

namespace Tests\Fixtures;

use Mockery as m;
use App\Models\User;
use App\Contracts\Orders\Order;
use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;

class ProductStub implements Product
{
    /**
     * The product name.
     *
     * @var string
     */
    protected $name;

    /**
     * The unique code of the product.
     *
     * @var string
     */
    protected $code;

    /**
     * The product order instance.
     *
     * @var \App\Contracts\Orders\Order
     */
    protected $order;

    /**
     * Datetime stamp indicating whether this product has been reserved.
     *
     * @var \Carbon\Carbon|null
     */
    protected $reservedAt;

    /**
     * All details related to the product.
     *
     * @var array
     */
    protected $details = [];

    /**
     * Create new product stub instance.
     *
     * @param string $name
     * @param array  $details
     */
    public function __construct(string $name, array $details = [])
    {
        $this->name = $name;
        $this->details = $details;
    }

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
        return $this->name;
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
        $this->code = $code;
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
        return $this->details['price'] ?? 0;
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
        return true;
    }

    /**
     * Get the details regarding the product.
     *
     * @return array
     */
    public function details(): array
    {
        return $this->details;
    }

    /**
     * Get the order associated with the product.
     *
     * @return mixed
     */
    public function order()
    {
        $this->order;
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
     * Destroy the mock product instance.
     *
     * @return void
     */
    public function __destruct()
    {
        m::close();
    }
}
