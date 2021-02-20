<?php

namespace Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Cratespace\Preflight\Models\Traits\Presentable;

class PresentableModel extends Model
{
    use Presentable;

    protected $table = 'presentable_models';
    protected $guarded = [];
}
