<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait GeneratesUID
{
    /**
     * Boot trait.
     */
    protected static function bootGeneratesUID()
    {
        static::creating(function ($model) {
            $model->uid = $model->uid ?? Str::random(7);
        });
    }
}
