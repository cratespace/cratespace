<?php

namespace Tests\Fixtures;

use App\Models\Traits\Directable;
use App\Models\Traits\Presentable;
use Illuminate\Database\Eloquent\Model;

class ModelStub extends Model
{
    use Presentable;
    use Directable;
}
