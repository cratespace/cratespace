<?php

namespace App\Products;

use Throwable;
use App\Support\Money;
use App\Contracts\Billing\Payable;
use Illuminate\Support\Facades\Crypt;

abstract class AbstractProduct implements Payable
{
    /**
     * The name used to identify the product.
     *
     * @var string
     */
    protected $name;

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
     * All product related details.
     *
     * @var array|null
     */
    protected $details;

    /**
     * Details that may or may not be included in the product information.
     *
     * @var array
     */
    protected $attributes = [
        'name',
        'amount',
        'description',
        'metadata',
        'package_dimensions',
    ];

    /**
     * Create new instance of product.
     *
     * @param string     $name
     * @param array|null $details
     *
     * @return void
     */
    public function __construct(string $name, ?array $details = null)
    {
        $this->name = $name;
        $this->details = $this->fillable($details);

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
     * Get the total amount that will be paid.
     *
     * @return string
     */
    public function amount(): string
    {
        return Money::format($this->fullAmount());
    }

    /**
     * Get the raw total amount that will be paid.
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return $this->details['amount'] ?? $this->fullAmount();
    }

    /**
     * Parse out the elements and return only the allowable details.
     *
     * @param array|null $details
     *
     * @return array
     */
    public function fillable(?array $details = null): array
    {
        if (is_null($details)) {
            return [];
        }

        return array_filter($details, function ($key) {
            return in_array($key, $this->attributes);
        }, \ARRAY_FILTER_USE_KEY);
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
        try {
            return $this->{$key};
        } catch (Throwable $e) {
            return $this->details[$key];
        }
    }
}
