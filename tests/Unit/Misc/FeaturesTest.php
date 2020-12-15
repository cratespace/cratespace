<?php

namespace Tests\Unit\Misc;

use Tests\TestCase;
use App\Features\Features;

class FeaturesTest extends TestCase
{
    /** @test */
    public function it_can_determine_if_specific_features_have_been_enabled()
    {
        config()->set('features.mock', ['mock-feature']);

        $this->assertTrue(MockFeature::enabled('mock-feature'));
    }

    /** @test */
    public function it_can_dynamically_check_for_features()
    {
        config()->set('features.mock', ['mock-feature']);

        $this->assertTrue(MockFeature::hasMockFeature());
    }
}

class MockFeature extends Features
{
    protected static $prefix = 'mock';

    public static function mockFeature()
    {
        return 'mock-feature';
    }
}
