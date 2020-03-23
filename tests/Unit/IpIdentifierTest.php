<?php

namespace Tests\Unit;

use Tests\TestCase;
use ReflectionObject;
use App\Http\Services\IpIdentifier;
use Stevebauman\Location\Facades\Location;

class IpIdentifierTest extends TestCase
{
    /** @test */
    public function it_can_evaluate_an_get_a_valid_ip_source()
    {
        $idetifier = new IpIdentifier;

        $this->assertNull($idetifier->get());
    }

    /** @test */
    public function it_can_identify_if_an_ip_is_private()
    {
        $idetifier = new IpIdentifier;
        $reflector = new ReflectionObject($idetifier);
        $method = $reflector->getMethod('isPrivate');
        $method->setAccessible(true);

        $this->assertTrue($method->invoke($idetifier, request()->ip()));
    }

    /** @test */
    public function it_can_get_position_information_using_an_ip()
    {
        $_SERVER['REMOTE_ADDR'] = '66.102.0.0';

        $idetifier = new IpIdentifier;

        $this->assertEquals(
            'United States',
            $idetifier->position()->countryName
        );

        unset($_SERVER['REMOTE_ADDR']);
        $_SERVER['REMOTE_ADDR'] = null;
    }
}
