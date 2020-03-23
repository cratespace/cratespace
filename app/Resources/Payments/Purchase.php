<?php

namespace App\Resources\Payments;

use App\Models\Space;

class Purchase
{
    /**
     * The price of the space at checkout.
     *
     * @var int
     */
    protected $price;

    /**
     * Gloabl tax rate.
     *
     * @var int
     */
    protected $taxRate;

    /**
     * Amount to be added to the original price as tax.
     *
     * @var int
     */
    protected $tax;

    /**
     * Rate of price charged for services provided.
     *
     * @var int
     */
    protected $serviceRate;

    /**
     * Price charged for services provided.
     *
     * @var int
     */
    protected $service;

    /**
     * Totl payable amount.
     *
     * @var int
     */
    protected $total;

    /**
     * Get summary of purchase and prices.
     *
     * @param   \App\Models\Space  $space
     *
     * @return  array
     */
    public function make(Space $space)
    {
        $this->price = $space->price;

        $this->caluculateTax()
            ->calculateServiceCharge()
            ->caluculateTotal();

        return [
            'space' => $space,
            'tax' => $this->tax,
            'service' => $this->service,
            'total' => $this->total,
        ];
    }

    /**
     * Calculate tax to added to the original price.
     *
     * @return  \App\Payments\Purchase
     */
    protected function caluculateTax()
    {
        $this->tax = $this->taxRate / 100 * $this->price;

        return $this;
    }

    /**
     * Calculate price of services provided.
     *
     * @return  \App\Payments\Purchase
     */
    protected function calculateServiceCharge()
    {
        $this->service = $this->serviceRate / 100 * $this->price;

        return $this;
    }

    /**
     * Calculate total amount to be paid by the customer.
     *
     * @return  \App\Payments\Purchase
     */
    protected function caluculateTotal()
    {
        $this->total = $this->price + $this->tax + $this->service;

        return $this;
    }

    /**
     * Set the global tax rate.
     *
     * @param   inetegr  $percentage
     */
    public function taxRate($percentage = null)
    {
        $this->taxRate = $percentage ?? config('pricing.rates.tax');
    }

    /**
     * Set the service charge rate.
     *
     * @param   inetegr  $percentage
     */
    public function serviceRate($percentage = null)
    {
        $this->serviceRate = $percentage ?? config('pricing.rates.service');
    }
}
