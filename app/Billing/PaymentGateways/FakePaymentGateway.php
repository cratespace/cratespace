<?php

namespace App\Billing\PaymentGateways;

use Tests\Fixtures\MockProduct;
use App\Contracts\Billing\Product;
use App\Exceptions\InvalidPurchaseTokenException;

class FakePaymentGateway extends PaymentGateway
{
    /**
     * Fake credit card number used for testing purposes.
     */
    public const TEST_CARD_NUMBER = '4242424242424242';

    /**
     * The total amount paid.
     *
     * @var int
     */
    protected $total = 0;

    /**
     * Charge the customer the given amount.
     *
     * @param int        $amount
     * @param array      $details
     * @param array|null $options
     *
     * @return mixed
     */
    public function charge(int $amount, array $details, ?array $options = null)
    {
        if (! $this->validPaymentToken($details['token'])) {
            throw new InvalidPurchaseTokenException();
        }

        $this->total += $amount;

        $this->successful = true;
    }

    /**
     * Generate valid test payment token.
     *
     * @param \App\Contracts\Billing\Product|null $product
     *
     * @return string
     */
    public function getValidTestToken(?Product $product = null): string
    {
        if (is_null($product)) {
            $product = new MockProduct(1);
        }

        return $this->createTokenGenerator()->generate($product);
    }

    protected function validPaymentToken(string $token)
    {
        return true;
    }
}
