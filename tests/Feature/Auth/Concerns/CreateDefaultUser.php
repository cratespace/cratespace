<?php

namespace Tests\Feature\Auth\Concerns;

trait CreateDefaultUser
{
    /**
     * Undocumented function.
     *
     * @return void
     */
    public function createDefaults(): void
    {
        $this->artisan('db:seed', ['class' => 'DefaultUserSeeder']);
    }
}
