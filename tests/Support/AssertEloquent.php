<?php

namespace Tests\Support;

use PHPUnit\Framework\Assert;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

class AssertEloquent
{
    /**
     * Register eloquent collection data assertion macros.
     *
     * @return void
     */
    public static function registerMacros(): void
    {
        EloquentCollection::macro('assertContains', function ($value) {
            Assert::assertTrue(
                $this->contains($value),
                'Failed asserting that the collection contains the specified value.'
            );
        });

        EloquentCollection::macro('assertNotContains', function ($value) {
            Assert::assertFalse(
                $this->contains($value),
                'Failed asserting that the collection does not contain the specified value.'
            );
        });

        EloquentCollection::macro('assertEquals', function ($items) {
            Assert::assertEquals(count($this), count($items));

            $this->zip($items)->each(function ($pair) {
                [$a, $b] = $pair;

                Assert::assertTrue($a->is($b));
            });
        });
    }
}
