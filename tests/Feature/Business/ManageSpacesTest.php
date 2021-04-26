<?php

namespace Tests\Feature\Business;

use Tests\TestCase;
use App\Models\User;
use Tests\Contracts\Postable;
use Database\Factories\SpaceFactory;
use Tests\Concerns\HasValidParameters;
use Illuminate\Contracts\Auth\StatefulGuard;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ManageSpacesTest extends TestCase implements Postable
{
    use HasValidParameters;
    use RefreshDatabase;

    /**
     * The space business instance.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * The space instance.
     *
     * @var \App\Products\Products\Space
     */
    protected $space;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->asBusiness()->create();

        $this->signIn($this->user);

        $this->space = SpaceFactory::createSpace([
            'user_id' => $this->user->id,
            'base' => $this->user->address->country,
        ]);
    }

    protected function tearDown(): void
    {
        $this->app->make(StatefulGuard::class)->logout();
    }

    public function testSpaceDetailsCanBeUpdated()
    {
        $response = $this->put(
            route('spaces.update', $this->space),
            $this->validParameters()
        );

        $response->assertStatus(303);
        $response->assertSessionHasNoErrors();
    }

    public function testSpaceDetailsCanBeUpdatedThroughJsonRequest()
    {
        $response = $this->putJson(
            route('spaces.update', $this->space),
            $this->validParameters()
        );

        $response->assertStatus(200);
    }

    public function testOnlyAuthenticatedUsersCanUpdateSpaceDetails()
    {
        $this->app->make(StatefulGuard::class)->logout();

        $this->assertGuest();

        $response = $this->put(
            route('spaces.update', $this->space),
            $this->validParameters()
        );

        $response->assertStatus(302);
        $response->assertRedirect('/login');
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
