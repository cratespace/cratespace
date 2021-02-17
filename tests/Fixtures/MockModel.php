<?php

namespace Tests\Fixtures;

use Illuminate\Database\Eloquent\Model;

class MockModel extends Model
{
    protected $table = 'mock_models';

    protected $guarded = [];
}
