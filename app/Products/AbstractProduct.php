<?php

namespace App\Products;

use Illuminate\Support\Facades\Crypt;

abstract class AbstractProduct
{
    /**
     * The unique code used to identify the product.
     *
     * @var string
     */
    protected $code;

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
     * @param string $name
     *
     * @return void
     */
    public function __construct(string $name)
    {
        $this->name = $name;

        $this->generateCode();
    }

    /**
     * Set merchant details.
     *
     * @param array $details
     *
     * @return void
     */
    public function setMerchantDetails(array $details): void
    {
        $this->merchant = $details;
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
     * @return void
     */
    public function generateCode(): void
    {
        $this->code = Crypt::encryptString(
            get_class($this) . '-' . $this->name
        );
    }

    /**
     * Determine if the space is reserved.
     *
     * @return bool
     */
    public function reserved(): bool
    {
        return ! is_null($this->reservedAt) && ! is_null($this->order);
    }

    /**
     * Dynamically get values from the product.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->{$key};
    }
}
