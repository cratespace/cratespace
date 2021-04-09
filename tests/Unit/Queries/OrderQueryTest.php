<?php

namespace Tests\Unit\Queries;

use Tests\TestCase;
use App\Models\Order;
use App\Queries\OrderQuery;
use App\Filters\OrderFilter;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderQueryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The query builder instance.
     *
     * @var \App\Queries\OrderQuery
     */
    protected $query;

    protected function setUp(): void
    {
        parent::setUp();

        $this->query = new OrderQuery();
    }

    public function testOrderListing()
    {
        $orders = create(Order::class, [], 20);

        $query = $this->query->listing(new OrderFilter(request()));

        $this->assertCount(20, $query->get());
    }
}
