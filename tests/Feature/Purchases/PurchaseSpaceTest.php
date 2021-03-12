<?php

namespace Tests\Feature\Purchases;

use stdClass;
use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use App\Billing\Payments\Gateway;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseSpaceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->paymentGateway = new stdClass();

        $this->app->instance(Gateway::class, $this->paymentGateway);
    }

    public function testCanPurchaseAvailableSpace()
    {
        $this->markTestSkipped();
        $this->withoutExceptionHandling();
        $this->createRolesAndPermissions();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = User::factory()->asCustomer()->create();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", [
                'name' => $user->name,
                'email' => $user->email,
                'payment_token' => 'sakldbsadjaysldajkshdasd',
            ]);

        $response->assertStatus(303);
        $this->assertEquals(1250, $this->paymentGateway->totalCharges());
        $this->assertNotNull($space->order);
        $this->assertEquals($user->email, $space->order->email);
    }
}
