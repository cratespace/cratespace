<?php

namespace App\Models\Casts;

use App\Services\Stripe\Payment;
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
        if (is_null($value)) {
            return null;
        }

        return new Payment($value);
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
        return $value;
    }
}
