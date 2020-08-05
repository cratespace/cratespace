<?php

namespace App\Models\Casts;

use App\Support\Formatter;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PriceCast implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return mixed
     */
    public function get($model, string $key, $value, array $attributes)
    {
        if (is_null($value)) {
            return $value;
        }

        return Formatter::money($value);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string                              $key
     * @param mixed                               $value
     * @param array                               $attributes
     *
     * @return array|string
     */
    public function set($model, string $key, $value, array $attributes)
    {
        return $value * 100;
    }
}
