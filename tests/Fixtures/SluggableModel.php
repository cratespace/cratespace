<?php

namespace Tests\Fixtures;

use App\Models\Traits\Sluggable;
use Illuminate\Database\Eloquent\Model;

class SluggableModel extends Model
{
    use Sluggable;

    protected $table = 'sluggable_models';
    protected $guarded = [];
}
