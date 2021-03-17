<?php

namespace App\Exceptions;

use Exception;
use App\Contracts\Purchases\Order;
use App\Http\Responses\OrderCancellationFailedResponse;

class OrderCancellationException extends Exception
{
    /**
     * Create a new OrderCancellationException instance.
     *
     * @param \App\Contracts\Purchases\Order $order
     *
     * @return mixed
     */
    public static function notEligible(Order $order)
    {
        $instance = new static(
            "Order no. {$order->confirmation_number} cannot be cancelled at this time."
        );

        return $instance->render(request());
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        return OrderCancellationFailedResponse::dispatch($this->getMessage());
    }
}
