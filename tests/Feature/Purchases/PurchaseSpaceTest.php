<?php

namespace Tests\Feature\Purchases;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Space;
use App\Actions\Purchases\GeneratePurchaseToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseSpaceTest extends TestCase
{
    use RefreshDatabase;

    public function testCanPurchaseAvailableSpace()
    {
        $this->withoutExceptionHandling();
        $this->createRolesAndPermissions();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $purchaseToken = (new GeneratePurchaseToken())->generate($space->code);
        $user = User::factory()->asCustomer()->create();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", [
                'name' => $user->name,
                'email' => $user->email,
                'payment_method' => 'pm_card_visa',
                'purchase_token' => $purchaseToken,
            ]);

        $response->assertStatus(303);
        $this->assertEquals(1250, $space->order->total);
        $this->assertNotNull($space->order);
        $this->assertEquals($user->email, $space->order->email);
    }

    public function testOnlyCustomersCanPurchaseSpace()
    {
        $role = Role::create(['name' => 'Editor', 'slug' => 'editor']);
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = create(User::class);
        $user->assignRole($role);

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", [
                'name' => $user->name,
                'email' => $user->email,
                'payment_method' => 'pm_card_visa',
            ]);

        $response->assertStatus(403);
    }
}
