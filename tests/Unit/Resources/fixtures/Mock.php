<?php

namespace Tests\Unit\Resources\fixtures;

use App\Models\Traits\Indexable;
use App\Models\Traits\Presentable;
use App\Models\Traits\Redirectable;
use Illuminate\Database\Eloquent\Model;

class Mock extends Model
{
    use Indexable;
    use Redirectable;
    use Presentable;

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