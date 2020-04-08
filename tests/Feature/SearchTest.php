<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Order;
use App\Models\Space;
use App\Models\Thread;

class SearchTest extends TestCase
{
    /** @test */
    public function a_user_can_search_spaces()
    {
        $this->withoutExceptionHandling();

        if (!$this->searchConfigured()) {
            $this->markTestSkipped('Search is not configured.');
        }

        config(['scout.driver' => 'tntsearch']);

        $user = $this->signIn();

        $search = 'foobar7839376';

        $desiredSpace = create(Space::class, [
            'uid' => $search,
            'user_id' => $user->id,
        ], 1);
        create(Space::class, ['user_id' => $user->id], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/spaces/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(1, $results);

        Space::all()->unsearchable();
    }

    /** @test */
    public function a_user_can_search_orders()
    {
        if (!$this->searchConfigured()) {
            $this->markTestSkipped('Search is not configured.');
        }

        config(['scout.driver' => 'tntsearch']);

        $user = $this->signIn();

        $search = 'Jerrold Jenkins';

        $desiredOrder = create(Order::class, [
            'name' => $search,
            'user_id' => $user->id,
        ]);
        create(Order::class, ['user_id' => $user->id], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/orders/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(1, $results);

        Order::all()->unsearchable();
    }

    /** @test */
    public function a_user_can_search_threads()
    {
        if (!$this->searchConfigured()) {
            $this->markTestSkipped('Search is not configured.');
        }

        config(['scout.driver' => 'tntsearch']);

        $user = $this->signIn();

        $search = 'Some random title comes here';

        $desiredThread = create(Thread::class, [
            'title' => $search,
            'user_id' => $user->id,
        ]);
        create(Thread::class, ['user_id' => $user->id], 2);

        do {
            sleep(.25);

            $results = $this->getJson("/support/threads/search?q={$search}")->json()['data'];
        } while (empty($results));

        $this->assertCount(1, $results);

        Thread::all()->unsearchable();
    }

    /**
     * Determine if laravel scout search is enabled.
     *
     * @return bool
     */
    protected function searchConfigured()
    {
        return method_exists(new Space(), 'search') &&
            method_exists(new Order(), 'search');
    }
}
