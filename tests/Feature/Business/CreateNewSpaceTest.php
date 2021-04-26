<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use App\Products\Products\Space;
use Tests\Concerns\HasValidParameters;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewSpaceTest extends TestCase implements Postable
{
    use HasValidParameters;
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

        $this->signIn($this->user);
    }

    public function testCreateNewSpace()
    {
        $this->withoutEvents();

        $response = $this->post('/spaces', $this->validParameters());

        $response->assertStatus(303);

        $this->assertCount(1, Space::all());
    }

    public function testCreateNewSpaceThroughJson()
    {
        $this->withoutEvents();

        $response = $this->postJson('/spaces', $this->validParameters());

        $response->assertStatus(201);

        $this->assertJson($response->getContent());
    }

    public function testOnlyAuthenticatedUsersCanCreateNewSpace()
    {
        $this->markTestSkipped();

        auth()->logout();

        $this->assertGuest();

        $response = $this->postJson('/spaces', $this->validParameters());

        $response->assertStatus(401);
    }

    public function testAutomaticUniqueCodeForSpace()
    {
        $response = $this->postJson('/spaces', $this->validParameters([
            'code' => '',
        ]));

        $content = json_decode($response->getContent(), true);

        $this->assertIsString($content['code']);
    }

    public function testAutomaticBaseAttributeForSpace()
    {
        $response = $this->postJson('/spaces', $this->validParameters());

        $content = json_decode($response->getContent(), true);

        $this->assertEquals($this->user->address->country, $content['base']);
    }

    public function testRequiresValidDepartsAt()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'departs_at' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('departs_at');
    }

    public function testRequiresValidArrivesAt()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'arrives_at' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('arrives_at');
    }

    public function testRequiresValidOrigin()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'origin' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('origin');
    }

    public function testRequiresValidDestination()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'destination' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('destination');
    }

    public function testRequiresValidHeight()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'height' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('height');
    }

    public function testRequiresValidWidth()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'width' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('width');
    }

    public function testRequiresValidLength()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'length' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('length');
    }

    public function testRequiresValidWeight()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'weight' => '',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('weight');
    }

    public function testRequiresValidPrice()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'price' => 'sdasdas',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('price');
    }

    public function testPriceIsConvertedToCents()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'price' => '12.50',
        ]));

        $response->assertStatus(303);
        $space = Space::whereUserId($this->user->id)->first();
        $this->assertEquals(1250, $space->price);
    }

    public function testTaxIsConvertedToCents()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'tax' => '0.50',
        ]));

        $response->assertStatus(303);
        $space = Space::whereUserId($this->user->id)->first();
        $this->assertEquals(50, $space->tax);
    }

    public function testTaxIsOptional()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'tax' => '',
        ]));

        $response->assertStatus(303);
    }

    public function testRequiresValidTax()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'tax' => 'sbfls',
        ]));

        $response->assertStatus(302);
        $response->assertSessionHasErrors('tax');
    }

    public function testRequiresValidType()
    {
        $response = $this->post('/spaces', $this->validParameters([
            'type' => 'Global',
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
        return static::validParametersForSpace($overrides);
    }
}
