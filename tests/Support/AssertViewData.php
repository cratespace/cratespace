<?php

namespace Tests\Support;

use Illuminate\Testing\TestResponse;

class AssertViewData
{
    /**
     * Register view data assertion macros.
     *
     * @return void
     */
    public static function registerMacros(): void
    {
        TestResponse::macro('data', function (string $key) {
            return $this->original->getData()[$key];
        });
    }
}
