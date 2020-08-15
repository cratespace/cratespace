<?php

namespace Tests\Feature\BusinessUserExperience;

use Tests\TestCase;
use App\Models\Space;
use PHPUnit\Framework\Assert;
use Illuminate\Testing\TestResponse;
use Illuminate\Database\Eloquent\Collection;

class ViewSpaceListTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        TestResponse::macro('data', function ($key) {
            return $this->original->getData()[$key];
        });

        Collection::macro('assertContains', function ($value) {
            return Assert::assertTrue($this->contains($value));
        });

        Collection::macro('assertDoesNotContain', function ($value) {
            return Assert::assertFalse($this->contains($value));
        });
    }

    /** @test */
    public function user_can_only_view_thir_own_spaces_listing()
    {
        $spacesOfUser = create(Space::class, ['user_id' => $user = $this->signIn()], 10);
        $spacesNotOfUser = create(Space::class, [], 10);

        $response = $this->get('/spaces');
        foreach ($spacesOfUser as $space) {
            $response->data('resource')->assertContains($space);
        }
        foreach ($spacesNotOfUser as $space) {
            $response->data('resource')->assertDoesNotContain($space);
        }
    }
}
