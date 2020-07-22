<?php

namespace App\Billing\Charges;

use App\Contracts\Billing\Charges;
use App\Contracts\Models\Priceable;

class Calculator
{
    /**
     * Instance of resource model adhering to "Priceable" interface.
     *
     * @var \App\Contracts\Models\Priceable
     */
    protected $resource;

    /**
     * List of all chrages to be applied to final amount.
     *
     * @var array
     */
    protected $charges = [
        'price' => SubTotalCharges::class,
        'service' => ServiceCharges::class,
        'tax' => TaxCharges::class,
    ];

    /**
     * All charges and calculated amount for current purchase.
     *
     * @var array
     */
    protected $amounts = [];

    /**
     * Create new billing charges amount calculator.
     *
     * @param \App\Contracts\Models\Priceable $resource
     */
    public function __construct(Priceable $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Calculates all applicable charges.
     *
     * @return array
     */
    public function calculateCharges(): array
    {
        foreach ($this->getCharges() as $chargeName => $charge) {
            $resource = $this->getResource();

            $this->amounts[$chargeName] = resolve($charge)->apply(
                ...$this->getPriceableAmounts()
            );
        }

        $this->amounts['total'] = array_sum($this->amounts);

        $this->saveAmountsToCache();

        return $this->amounts;
    }

    /**
     * Get all pricing amounts including tax for the given resource.
     *
     * @return array
     */
    protected function getPriceableAmounts(): array
    {
        return [$this->getPriceAmount(), $this->getTaxAmount()];
    }

    /**
     * Get price amount in cents.
     *
     * @return int
     */
    protected function getPriceAmount(): int
    {
        return $this->getChargeAmountInCents($this->getResource()->price);
    }

    /**
     * Get tax amount in cents.
     *
     * @return int
     */
    protected function getTaxAmount(): int
    {
        return $this->getChargeAmountInCents($this->getResource()->tax ?? 0);
    }

    /**
     * Get chargable amount in cents.
     *
     * @param $amount
     *
     * @return int
     */
    protected function getChargeAmountInCents($amount): int
    {
        return $this->getResource()->getChargeAmountInCents($amount);
    }

    /**
     * Save calculated charges to cache.
     *
     * @return void
     */
    protected function saveAmountsToCache(): void
    {
        cache()->put('charges', $this->amounts);
    }

    /**
     * Get instance of resource.
     *
     * @return \App\Contracts\Models\Priceable
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Get list of all charges to be applied to final amount.
     *
     * @return array
     */
    public function getCharges(): array
    {
        return $this->charges;
    }
}
