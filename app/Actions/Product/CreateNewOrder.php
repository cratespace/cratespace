<?php

namespace App\Actions\Product;

use App\Contracts\Actions\MakesPurchases;
use App\Contracts\Actions\CreatesNewResources;
use App\Billing\PaymentTokens\DestroyPaymentToken;

class CreateNewOrder implements CreatesNewResources
{
    /**
     * The purchase maker instance.
     *
     * @var \App\Contracts\Actions\MakesPurchases
     */
    protected $purchaser;

    /**
     * The payment token destroyer instance.
     *
     * @var \App\Actions\Customer\DestroyPaymentToken
     */
    protected $destroyer;

    /**
     * Create new instace of CreateNewOrder action class.
     *
     * @param \App\Contracts\Actions\MakesPurchases     $purchaser
     * @param \App\Actions\Customer\DestroyPaymentToken $destroyer
     *
     * @return void
     */
    public function __construct(MakesPurchases $purchaser, DestroyPaymentToken $destroyer)
    {
        $this->purchaser = $purchaser;
        $this->destroyer = $destroyer;
    }

    /**
     * Create a new resource.
     *
     * @param mixed $resource
     * @param array $data
     *
     * @return mixed
     */
    public function create($resource, array $data)
    {
        $order = $this->purchaser->purchase($resource, $data);

        $this->destroyer->destroy($data['payment_token']);

        return $order;
    }
}
