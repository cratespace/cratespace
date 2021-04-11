<?php

namespace Tests\Unit\Ipinfo;

use Tests\TestCase;
use Illuminate\Http\Request;
use App\Services\Ipinfo\Client;

class ClientTest extends TestCase
{
    public function testGetIpDetails()
    {
        $request = Request::create('/', 'GET');
        $client = new Client($request);
        $client->make(['access_token' => null]);

        $details = $client->getDetails('43.228.108.0');

        $this->assertEquals('Colombo', $details->city);
        $this->assertEquals('Western', $details->region);
        $this->assertEquals('LK', $details->country);
    }
}
