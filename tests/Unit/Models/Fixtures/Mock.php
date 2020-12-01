<?php

namespace Tests\Unit\Models\Fixtures;

use App\Models\Traits\Indexable;
use App\Models\Traits\Redirectable;
use Illuminate\Database\Eloquent\Model;

class Mock extends Model
{
    use Indexable;
    use Redirectable;

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'id';
    }
}
