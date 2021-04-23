<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use App\Models\Space;
use Tests\Contracts\Postable;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AddSpacesTest extends TestCase implements Postable
{
    use RefreshDatabase;

    /**
     * The business user instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asBusiness()->create();
    }

    public function testAddNewSpaceDetails()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(303);
    }

    public function testAddNewSpaceDetailsThroughJson()
    {
        $this->signIn($this->user);

        $response = $this->postJson('/spaces', $this->validParameters([
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(201);
        $this->assertJson($response->getContent());
    }

    public function testOnlyAuthenticatedUsersCanAddSpaceDetails()
    {
        $this->signIn($this->user);

        auth()->logout();

        $this->assertGuest();

        $response = $this->post('/spaces', $this->validParameters([
            'base' => 'MockCountry',
        ]));

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testGuestUsersAreRedirectedToLoginPage()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'base' => 'MockCountry',
        ]));

        $response->assertStatus(302);
        $response->assertRedirect('/login');
    }

    public function testAutomaticUniqueHashCodeForSpace()
    {
        $this->signIn($this->user);

        $response = $this->postJson('/spaces', $this->validParameters([
            'base' => $this->user->address->country,
        ]));

        $content = json_decode($response->getContent(), true);
        $this->assertIsString($content['code']);
    }

    public function testAutomaticBaseAttributeForSpace()
    {
        $this->signIn($this->user);

        $response = $this->postJson('/spaces', $this->validParameters());

        $content = json_decode($response->getContent(), true);

        $this->assertEquals($this->user->address->country, $content['base']);
    }

    public function testRequiresValidDepartsAt()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'departs_at' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('departs_at');
    }

    public function testRequiresValidArrivesAt()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'arrives_at' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('arrives_at');
    }

    public function testRequiresValidOrigin()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'origin' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('origin');
    }

    public function testRequiresValidDestination()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'destination' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('destination');
    }

    public function testRequiresValidHeight()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'height' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('height');
    }

    public function testRequiresValidWidth()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'width' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('width');
    }

    public function testRequiresValidLength()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'length' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('length');
    }

    public function testRequiresValidWeight()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'weight' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('weight');
    }

    public function testRequiresValidPrice()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'price' => 'sdasdas',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('price');
    }

    public function testPriceIsConvertedToCents()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'price' => '12.50',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(303);
        $space = Space::whereUserId($this->user->id)->first();
        $this->assertEquals(1250, $space->price);
    }

    public function testTaxIsConvertedToCents()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'tax' => '0.50',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(303);
        $space = Space::whereUserId($this->user->id)->first();
        $this->assertEquals(50, $space->tax);
    }

    public function testTaxIsOptional()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'tax' => '',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(303);
    }

    public function testRequiresValidTax()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'tax' => 'sbfls',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('tax');
    }

    public function testRequiresValidType()
    {
        $this->signIn($this->user);

        $response = $this->post('/spaces', $this->validParameters([
            'type' => 'Global',
            'base' => $this->user->address->country,
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('type');
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
        return array_merge([
            'departs_at' => now()->addMonths(rand(1, 2)),
            'arrives_at' => now()->addMonths(rand(3, 4)),
            'origin' => $this->faker->city,
            'destination' => $this->faker->city,
            'height' => rand(1, 9),
            'width' => rand(1, 9),
            'length' => rand(1, 9),
            'weight' => rand(1, 9),
            'note' => $this->faker->sentence(7),
            'price' => 10.00,
            'tax' => 0.50,
            'type' => $this->faker->randomElement(['Local', 'International']),
        ], $overrides);
    }
}
