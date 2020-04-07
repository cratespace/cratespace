<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait GeneratesUid
{
    /**
     * Boot GeneratesUid trait.
     */
    public static function bootGeneratesUid()
    {
        static::creating(function ($model) {
            $model->uid = strtoupper(Str::random(20));
        });
    }
}
