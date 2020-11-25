<?php

namespace App\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpException;

class PaymentFailedException extends HttpException
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
     * @param int|null    $amount
     */
    public function __construct(?string $message = null, ?int $amount = null)
    {
        $this->amount = $amount;

        parent::__construct(422, $message, null, [], 0);
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
        return response(
            ['message' => $this->getMessage()],
            $this->getStatusCode()
        );
    }

    /**
     * Get total amount charged by payment gateway.
     *
     * @return int|null
     */
    public function chargedAmount(): ?int
    {
        return $this->amount;
    }
}
