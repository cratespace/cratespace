<?php

namespace App\Models;

use App\Models\Traits\Recordable;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    use Recordable;

    /**
     * Don't auto-apply mass assignment protection.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Fetch the model that was favorited.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function favorited()
    {
        return $this->morphTo();
    }
}
