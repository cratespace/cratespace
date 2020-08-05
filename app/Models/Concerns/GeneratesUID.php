<?php

namespace App\Models\Concerns;

use Facades\App\Support\UidGenerator;

trait GeneratesUID
{
    /**
     * Boot trait.
     */
    protected static function bootGeneratesUID()
    {
        static::creating(function ($model) {
            $model->uid = $model->uid ?? UidGenerator::generate();
        });
    }
}
