<?php

namespace App\Billing\Attributes;

use App\Support\Attribute;
use Stripe\TaxRate as StripeTaxRate;
use App\Contracts\Billing\Payment as PaymentContract;

class Tax extends Attribute implements PaymentContract
{
    /**
     * Attribute identifier.
     *
     * @var string
     */
    protected $name = 'tax';

    /**
     * The total tax amount.
     *
     * @var int
     */
    protected $amount;

    /**
     * The applied currency.
     *
     * @var string
     */
    protected $currency;

    /**
     * The Stripe TaxRate object.
     *
     * @var \Stripe\TaxRate
     */
    protected $taxRate;

    /**
     * Create a new Tax instance.
     *
     * @param int             $amount
     * @param string          $currency
     * @param \Stripe\TaxRate $taxRate
     *
     * @return void
     */
    public function __construct($amount, $currency, StripeTaxRate $taxRate)
    {
        $this->amount = $amount;
        $this->currency = $currency;
        $this->taxRate = $taxRate;
    }

    /**
     * Get the applied currency.
     *
     * @return string
     */
    public function currency()
    {
        return $this->currency;
    }

    /**
     * Get the total tax that was paid (or will be paid).
     *
     * @return string
     */
    public function amount(): string
    {
        return $this->formatAmount($this->amount);
    }

    /**
     * Get the raw total tax that was paid (or will be paid).
     *
     * @return int
     */
    public function rawAmount(): int
    {
        return $this->amount;
    }

    /**
     * Determine if the tax is inclusive or not.
     *
     * @return bool
     */
    public function isInclusive()
    {
        return $this->taxRate->inclusive;
    }

    /**
     * @return \Stripe\TaxRate
     */
    public function taxRate()
    {
        return $this->taxRate;
    }

    /**
     * Validate if the payment intent was successful and throw an exception if not.
     *
     * @return void
     *
     * @throws \App\Exceptions\PaymentFailedException
     * @throws \App\Exceptions\PaymentFailure
     */
    public function validate(): void
    {
    }

    /**
     * Determine the status of the order.
     *
     * @return string
     */
    public function status(): string
    {
        return $this->status;
    }

    /**
     * Dynamically get values from the Stripe TaxRate.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->taxRate->{$key};
    }
}
