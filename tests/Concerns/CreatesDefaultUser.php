<?php

namespace Tests\Concerns;

trait CreatesDefaultUser
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
