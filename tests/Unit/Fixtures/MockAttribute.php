<?php

namespace Tests\Unit\Fixtures;

use App\Support\Attribute;

class MockAttribute extends Attribute
{
    /**
     * Attribute identifier.
     *
     * @var string
     */
    protected $name = 'mock';
}
