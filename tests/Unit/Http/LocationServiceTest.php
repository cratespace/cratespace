<?php

namespace Tests\Unit\Http;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Services\IpService;
use Stevebauman\Location\Position;
use App\Http\Services\LocationService;

class LocationServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($_SERVER['HTTP_CLIENT_IP'], $_SERVER['HTTP_X_FORWARDED_FOR'], $_SERVER['REMOTE_ADDR']);

        $_SERVER['HTTP_CLIENT_IP'] = null;
        $_SERVER['HTTP_X_FORWARDED_FOR'] = null;
        $_SERVER['REMOTE_ADDR'] = null;
    }

    /** @test */
    public function it_can_get_the_location_of_the_user_making_the_http_reqeust()
    {
        if (!$this->isConnected()) {
            $this->markTestSkipped('An Internet connection is not available.');
        }

        config()->set('location.testing.enabled', true);

        $_SERVER['HTTP_CLIENT_IP'] = '192.168.1.8';
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '122.255.0.0';
        $_SERVER['REMOTE_ADDR'] = '192.168.1.8';

        $request = Request::create('/', 'GET');
        $ipService = new IpService($request);
        $location = new LocationService($request, $ipService);

        $this->assertEquals('122.255.0.0', $ipService->get());
        $this->assertEquals('122.255.0.0', $location->getValidIp());
        $this->assertInstanceOf(Position::class, $location->get());
        $this->assertEquals('Sri Lanka', $location->getCountry());
    }
}
