<?php

namespace App\Processes\Orders;

use InvalidArgumentException;
use Facades\App\Calculators\Purchase;
use App\Events\PaymentProcessingSucceeded;
use App\Contracts\Process as ProcessorContract;
use App\Processes\Orders\Concerns\IdentifiesResource;

class Payment implements ProcessorContract
{
    use IdentifiesResource;

    /**
     * Process given data and follow relevant procedures.
     *
     * @param  array $value
     * @return void
     */
    public function perform(array $data)
    {
        try {
            $prices = $this->processPayment($data);
        } catch (InvalidArgumentException $e) {
            abort(402, $e->getMessage());
        }

        event(new PaymentProcessingSucceeded($prices));
    }

    /**
     * Process relevant payment processing.
     *
     * @param  array  $data
     * @return bool
     */
    protected function processPayment(array $data)
    {
        if (! is_array($data)) {
            throw new InvalidArgumentException();
        }

        $prices = Purchase::calculate($this->getDetails()->price)->getAmounts();

        cache()->put('prices', $prices);

        return $prices;
    }
}
