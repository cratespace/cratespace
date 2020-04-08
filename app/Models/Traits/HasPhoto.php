<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasPhoto
{
    /**
     * Get the books cover image.
     *
     * @param string $value
     *
     * @return string
     */
    public function getPhotoAttribute($value)
    {
        if (Str::contains($value, 'http')) {
            return $value;
        }

        return asset($value ?? 'img/default.jpg');
    }
}
