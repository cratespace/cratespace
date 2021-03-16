<?php

namespace App\Models\Casts;

use App\Billing\Stripe\Payment;
use App\Contracts\Billing\Client;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PaymentCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return mixed
     */
    public function get($model, $key, $value, $attributes)
    {
        return new Payment(
            app(Client::class)->getIntent(json_decode($value, true)['id'])
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return mixed
     */
    public function set($model, $key, $value, $attributes)
    {
        return json_encode($value);
    }
}
