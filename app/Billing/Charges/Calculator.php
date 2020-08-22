<?php

namespace App\Billing\Charges;

use RuntimeException;
use Illuminate\Pipeline\Pipeline;
use Illuminate\Support\Collection;
use App\Contracts\Models\Priceable;
use App\Contracts\Billing\Calculation;
use App\Billing\Charges\Calculations\TaxCalculation;
use App\Billing\Charges\Calculations\PriceCalculation;
use App\Billing\Charges\Calculations\TotalCalculation;
use App\Billing\Charges\Calculations\ServiceCalculation;
use App\Billing\Charges\Calculations\SubTotalCalculation;
use App\Contracts\Support\Calculator as CalculatorContract;

class Calculator implements CalculatorContract
{
    /**
     * Instance of resource model adhering to "Priceable" interface.
     *
     * @var \App\Contracts\Models\Priceable
     */
    protected $resource;

    /**
     * List of all charges to be applied to final amount.
     *
     * @var array
     */
    protected $calculations = [
        'price' => PriceCalculation::class,
        'subtotal' => SubTotalCalculation::class,
        'service' => ServiceCalculation::class,
        'tax' => TaxCalculation::class,
        'total' => TotalCalculation::class,
    ];

    /**
     * All charges and calculated amount for current purchase.
     *
     * @var array
     */
    protected $amounts = [];

    /**
     * Create new instance of charges calculator.
     *
     * @param \App\Contracts\Models\Priceable $resource
     */
    public function __construct(Priceable $resource)
    {
        $this->resource = $resource;
        $this->amounts = collect();
    }

    /**
     * Perform calculations.
     *
     * @return mixed
     */
    public function calculate()
    {
        (new Pipeline(app()))->send($this->resourceCharges())
            ->through($this->calculations)
            ->via('handle')
            ->then(function ($amounts) {
                $this->saveAmountsToCache($this->amounts = $amounts);
            });
    }

    /**
     * Resolve calculation service.
     *
     * @param string $service
     *
     * @return \App\Contracts\Billing\Calculation
     */
    protected function resolveCalculationService(string $service): Calculation
    {
        $service = resolve($service);

        if (!$service instanceof Calculation) {
            $service = class_basename($service);

            throw new RuntimeException("Class {$service} is not a valid charge calculations service");
        }

        return $service;
    }

    /**
     * Save calculated charges to pipeline.
     *
     * @param array $amounts
     *
     * @return void
     */
    protected function saveAmountsToCache(array $amounts): void
    {
        cache()->put('charges', $amounts);
    }

    /**
     * Get calculated charge amounts.
     *
     * @return array
     */
    public function amounts(): array
    {
        return $this->amounts;
    }

    /**
     * Get instance of resource.
     *
     * @return \App\Contracts\Models\Priceable
     */
    public function resource()
    {
        return $this->resource;
    }

    /**
     * All amounts of the resource to be summed up for the total charge amount.
     *
     * @return array
     */
    public function resourceCharges(): array
    {
        return $this->resource()->getCharges();
    }

    /**
     * Get list of all charges to be applied to final amount.
     *
     * @return \Illuminate\Support\Collection
     */
    public function calculations(): Collection
    {
        return collect($this->calculations)
            ->merge(config('defaults.billing.charges.calculations'));
    }
}
