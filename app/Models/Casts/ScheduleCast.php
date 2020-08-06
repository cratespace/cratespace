<?php

namespace App\Models\Casts;

use Carbon\Carbon;
use App\Models\Values\ScheduleValue;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class ScheduleCast implements CastsAttributes
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
        return new ScheduleValue(
            Carbon::parse($attributes['departs_at'])->format('M j, Y'),
            Carbon::parse($attributes['arrives_at'])->format('M j, Y')
        );
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
        return [
            'departs_at' => Carbon::parse($value->departsAt)->toDateTimeString(),
            'arrives_at' => Carbon::parse($value->arrivesAt)->toDateTimeString(),
        ];
    }
}
