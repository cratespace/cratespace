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
        static::creating(function ($ticket) {
            $ticket->uid = strtoupper(Str::random(20));
        });
    }
}
