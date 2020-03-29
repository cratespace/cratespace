<?php

namespace App\Processes\Orders;

use App\Models\Order;
use App\Events\OrderPlaced;
use App\Contracts\Process as ProcessContract;
use App\Exceptions\ResourceNotFoundException;
use App\Processes\Orders\Concerns\CalculatesPrices;
use App\Processes\Orders\Concerns\IdentifiesResource;

class NewOrder implements ProcessContract
{
    use IdentifiesResource, CalculatesPrices;

    /**
     * Process given data and follow relevant procedures.
     *
     * @param  array $value
     * @return void
     */
    public function perform(array $data)
    {
        $order = Order::create(
            $this->prepareData($data)
        );

        event(new OrderPlaced($order));

        cache()->flush();
    }

    /**
     * Collect and prepare all relevant data to create a new order.
     *
     * @param  array  $data
     * @return array
     */
    protected function prepareData(array $data)
    {
        return array_merge(
            array_merge($data, cache('prices')),
            [
                'space_id' => $this->getDetails()->id,
                'user_id' => $this->getDetails()->user->id
            ]
        );
    }
}
