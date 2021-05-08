<?php

namespace Tests\Fixtures;

use Mockery as m;
use App\Models\User;
use App\Support\Money;
use Illuminate\Support\Str;
use InvalidArgumentException;
use App\Contracts\Orders\Order;
use App\Contracts\Billing\Payment;
use App\Contracts\Products\Product;

class ProductStub implements Product
{
    /**
     * The name of the product.
     *
     * @var string
     */
    protected $name;

    /**
     * The product price in integers.
     *
     * @var int
     */
    protected $amount;

    /**
     * The unique code.
     *
     * @var string
     */
    protected $code;

    /**
     * Indicate if the product has been reserved.
     *
     * @var bool
     */
    protected $reserved = false;

    /**
     * The product merchant.
     *
     * @var mixed
     */
    protected $merchant;

    /**
     * Create new ProductStub instance.
     *
     * @param string      $name
     * @param int         $amount
     * @param string|null $code
     *
     * @return void
     */
    public function __construct(string $name, int $amount, ?string $code = null)
    {
        $this->name = $name;
        $this->amount = $amount;
        $this->code = $code ?? Str::upper(Str::random(7));

        $this->merchant = create(User::class, [], 'asBusiness');
    }

    /**
     * Get the product name.
     *
     * @return string
     */
    public function getName(): string
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
     * The unique code used to identify the product.
     *
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

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
        return $this->amount;
    }

    /**
     * Get the owner of the product.
     *
     * @return mixed
     */
    public function merchant()
    {
        return $this->merchant;
    }

    /**
     * Reserve product for customer.
     *
     * @return void
     */
    public function reserve(): void
    {
        $this->reserved = true;
    }

    /**
     * Release space from order.
     *
     * @return void
     */
    public function release(): void
    {
        $this->reserved = false;
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

        return $order;
    }

    /**
     * Determine if the product is available for purchase.
     *
     * @return bool
     */
    public function available(): bool
    {
        return ! $this->reserved;
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
        if ($this->code === $code) {
            return $this;
        }

        throw new InvalidArgumentException("Code [{$code}] does not belong to this product.");
    }
}
