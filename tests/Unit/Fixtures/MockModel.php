<?php

namespace Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;

class MockModel extends Model
{
    protected $table = 'mock_models';

    protected $guarded = [];
}
