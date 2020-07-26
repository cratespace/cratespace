<?php

namespace App\Models\Casts;

use App\Models\Values\SettingsValue;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class SettingsCast implements CastsAttributes
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
        return $this->getValueObject(json_decode($value, true));
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
        return json_encode($value);
    }

    protected function getValueObject(array $value)
    {
        return new SettingsValue($value);
    }
}
