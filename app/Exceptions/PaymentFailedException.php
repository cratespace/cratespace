<?php

namespace App\Exceptions;

use RuntimeException;

class PaymentFailedException extends RuntimeException
{
    /**
     * Total amount charged to customer.
     *
     * @var int
     */
    protected $amount;

    /**
     * Create new instance of payment failed exception.
     *
     * @param string|null $message
     * @param int         $amount
     */
    public function __construct(string $message = null, int $amount)
    {
        $this->amount = $amount;

        parent::__construct($message);
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
        return response(['message' => $this->getMessage()], 422);
    }

    /**
     * Get total amount charged by payment gateway.
     *
     * @return int
     */
    public function chargedAmount(): int
    {
        return $this->amount;
    }
}
