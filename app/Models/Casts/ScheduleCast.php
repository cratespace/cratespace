<?php

namespace App\Models\Casts;

use Carbon\Carbon;
use App\Models\Values\Schedule;
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
        $model->validateSchedule();

        return new Schedule(
            $this->parse($attributes['departs_at'])->format('M j, Y g:ia'),
            $this->parse($attributes['arrives_at'])->format('M j, Y g:ia')
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
            'departs_at' => $this->parse($value->departsAt)->toDateTimeString(),
            'arrives_at' => $this->parse($value->arrivesAt)->toDateTimeString(),
        ];
    }

    /**
     * Parse the given datetime value to Carbon instance.
     *
     * @param \Carbon\Carbon|string $datetime
     *
     * @return \Carbon\Carbon
     */
    protected function parse($datetime): Carbon
    {
        return Carbon::parse($datetime);
    }
}
