<?php

namespace Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;

class MockOrderModel extends Model
{
    protected $table = 'mock_orders';

    protected $guarded = [];
}
