<?php

namespace App\Models\Concerns;

use App\Models\Space;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait HasProducts
{
    /**
     * Get business details of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function products(): HasMany
    {
        return $this->hasMany(Space::class, 'user_id');
    }
}
