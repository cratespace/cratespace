<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class PurchaseTest extends TestCase implements Postable
{
    use RefreshDatabase;

    public function testPurchaseProduct()
    {
        Event::fake();

        $this->withoutExceptionHandling();

        $customer = User::factory()->asCustomer()->create();
        $product = create(Space::class);

        $this->signIn($customer);

        $response = $this->post('/orders/' . $product->code, [
            'name' => 'James Silverman',
            'email' => 'james.silver@monster.com',
            'phone' => '0723573567',
            'business' => 'Cthulus',
            'payment_method' => 'pm_card_visa',
        ]);

        $response->assertStatus(303);
    }

    /**
     * Provide only the necessary paramertes for a POST-able type request.
     *
     * @param array $overrides
     *
     * @return array
     */
    public function validParameters(array $overrides = []): array
    {
        return array_merge([], $overrides);
    }
}
