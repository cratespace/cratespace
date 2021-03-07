<?php

namespace Tests\Unit\Presenters;

use Tests\TestCase;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessPresenterTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGetFullAddressAsString()
    {
        $business = create(Business::class, [
            'street' => '59 Martin Road',
            'city' => 'Jaffna',
            'state' => 'Northern Province',
            'country' => 'Sri Lanka',
            'postcode' => '40000',
        ]);

        $this->assertEquals(
            '59 Martin Road, Jaffna, Northern Province, Sri Lanka, 40000',
            $business->present()->address()
        );
    }

    public function testCanMutateMoneyValue()
    {
        $business = create(Business::class, ['credit' => 800]);

        $this->assertEquals('$8.00', $business->present()->credit);
    }
}
