<?php

namespace Tests\Unit\Http;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Http\Services\IpService;

class IpServiceTest extends TestCase
{
    protected function tearDown(): void
    {
        unset($_SERVER['HTTP_CLIENT_IP'], $_SERVER['HTTP_X_FORWARDED_FOR'], $_SERVER['REMOTE_ADDR']);

        $_SERVER['HTTP_CLIENT_IP'] = null;
        $_SERVER['HTTP_X_FORWARDED_FOR'] = null;
        $_SERVER['REMOTE_ADDR'] = null;
    }

    /** @test */
    public function it_can_retrieve_a_valid_ip_address()
    {
        $_SERVER['HTTP_CLIENT_IP'] = '192.168.1.8';
        $_SERVER['HTTP_X_FORWARDED_FOR'] = '66.102.0.0';
        $_SERVER['REMOTE_ADDR'] = '192.168.1.8';

        $ipService = new IpService(Request::create('/', 'GET'));

        $this->assertEquals('66.102.0.0', $ipService->get());
    }
}
