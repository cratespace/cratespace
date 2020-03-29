<?php

namespace App\Processes\Orders;

use InvalidArgumentException;
use App\Events\PaymentProcessingSucceeded;
use App\Contracts\Process as ProcessorContract;
use App\Processes\Orders\Concerns\CalculatesPrices;
use App\Processes\Orders\Concerns\IdentifiesResource;

class Payment implements ProcessorContract
{
    use IdentifiesResource, CalculatesPrices;

    /**
     * Details of the resource currently being purchased.
     *
     * @var \App\Models\Space
     */
    protected $details;

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
        } catch (InvalidArgumentException $exception) {
            abort(402, $exception->getMessage());
        }

        event(new PaymentProcessingSucceeded(
            $this->details->user,
            $prices['credit']
        ));
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

        $this->details = $this->getDetails();

        return $this->calculate($this->details->price);
    }
}
