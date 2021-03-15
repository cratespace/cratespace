<?php

namespace Tests\Feature\Purchases;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Space;
use App\Models\Charge;
use App\Events\OrderPlaced;
use App\Events\SpaceReserved;
use App\Events\PaymentSuccessful;
use App\Contracts\Purchases\Product;
use Illuminate\Support\Facades\Event;
use App\Actions\Purchases\GeneratePurchaseToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Cratespace\Preflight\Testing\Contracts\Postable;

class PurchaseSpaceTest extends TestCase implements Postable
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createRolesAndPermissions();
    }

    public function testCanPurchaseAvailableSpace()
    {
        Event::fake();

        $this->withoutExceptionHandling();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'purchase_token' => $this->generateToken($space),
            ]));

        $charge = $this->getChargeDetails($space);

        $response->assertStatus(303);
        $this->assertEquals(1250, $space->order->total);
        $this->assertEquals(1250, $charge->rawAmount());
    }

    public function testCannotPurchaseUnavailableSpace()
    {
        Event::fake();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $space->reserve();
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'purchase_token' => $this->generateToken($space),
            ]));

        $response->assertStatus(403);
    }

    public function testCanPurchaseAvailableSpaceThroughJson()
    {
        Event::fake();

        $this->withoutExceptionHandling();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->postJson(
                "/spaces/{$space->code}/orders",
                $this->validParameters([
                    'purchase_token' => $this->generateToken($space),
                ])
            );

        $charge = $this->getChargeDetails($space);
        $order = json_decode($response->getContent(), true);

        $response->assertStatus(201);
        $this->assertEquals($order['total'], $charge->rawAmount());
        $this->assertEquals($order['total'], $space->order->total);
    }

    public function testValidNameIsRequired()
    {
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'name' => '',
                'purchase_token' => $this->generateToken($space),
            ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('name');
    }

    public function testValidEmailIsRequired()
    {
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'email' => '',
                'purchase_token' => $this->generateToken($space),
            ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('email');
    }

    public function testValidPhoneIsRequired()
    {
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'phone' => '',
                'purchase_token' => $this->generateToken($space),
            ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('phone');
    }

    public function testValidPurchaseTokenIsRequired()
    {
        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'purchase_token' => '',
            ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('purchase_token');
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

    public function testPurchaseTriggersSpaceReservedEvent()
    {
        Event::fake();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'purchase_token' => $this->generateToken($space),
            ]));

        $response->assertStatus(303);

        Event::assertDispatched(function (SpaceReserved $event) use ($space) {
            return $event->space->is($space);
        });
    }

    public function testPurchaseTriggersOrderPlacedEvent()
    {
        Event::fake();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'purchase_token' => $this->generateToken($space),
            ]));

        $response->assertStatus(303);

        Event::assertDispatched(function (OrderPlaced $event) use ($space) {
            return $event->order->total === $space->fullPrice();
        });
    }

    public function testSuccessfulPurchaseTriggersPaymentSuccessfulEvent()
    {
        Event::fake();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'purchase_token' => $this->generateToken($space),
            ]));

        $response->assertStatus(303);

        Event::assertDispatched(function (PaymentSuccessful $event) use ($space) {
            return $event->business()->is($space->user->business);
        });
    }

    public function testSuccessfulPurchaseWillCreditBusiness()
    {
        $this->withoutExceptionHandling();

        $space = create(Space::class, ['price' => 1200, 'tax' => 50]);
        $user = $this->createCustomer();

        $response = $this->signIn($user)
            ->post("/spaces/{$space->code}/orders", $this->validParameters([
                'purchase_token' => $this->generateToken($space),
            ]));

        $charge = $this->getChargeDetails($space);

        $response->assertStatus(303);
        $this->assertEquals(1250, $charge->rawAmount());
        $this->assertEquals(1212, $space->user->business->credit); // 3% service charge
    }

    /**
     * Generate mock purchase token.
     *
     * @param \App\Contracts\Purchases\Product $product
     *
     * @return string
     */
    protected function generateToken(Product $product): string
    {
        return (new GeneratePurchaseToken())->generate($product->id());
    }

    /**
     * Create a user with customer role.
     *
     * @return \App\Models\User
     */
    protected function createCustomer(): User
    {
        return User::factory()->asCustomer()->create();
    }

    /**
     * Get charge details of given product.
     *
     * @param \App\Contracts\Purchases\Product $product
     *
     * @return \App\Models\Charge
     */
    protected function getChargeDetails(Product $product): Charge
    {
        return Charge::where('product_id', $product->id)->first();
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
        $user = $this->createCustomer();

        return array_merge([
            'name' => $user->name,
            'email' => $user->email,
            'payment_method' => 'pm_card_visa',
        ], $overrides);
    }
}
