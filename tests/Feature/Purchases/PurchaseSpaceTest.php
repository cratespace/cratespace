<?php

namespace Tests\Feature\Purchases;

use Tests\TestCase;
use App\Models\Space;
use App\Billing\Payments\Gateway;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseSpaceTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPurchaseAvailableSpace()
    {
        $this->withoutExceptionHandling();

        $paymentGateway = app(Gateway::class);
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);

        $response = $this->post("/spaces/{$space->code}/orders", [
            'name' => 'Johnny Janson',
            'email' => 'martin@payments.com',
            'payment_token' => $paymentGateway->getValidToken(),
        ]);

        $response->assertStatus(303);
        $this->assertEquals(1250, $paymentGateway->totalCharges());
        $this->assertNotNull($space->order);
    }
}
