<?php

namespace Tests\Fixtures;

use App\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Model;

class PresentableModel extends Model
{
    use Presentable;

    protected $table = 'presentable_models';
    protected $guarded = [];
}
