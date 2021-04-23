<?php

namespace Tests\Unit\Support;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Tests\Concerns\AuthenticatesUser;
use Tests\Concerns\InteractsWithNetwork;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Concerns\InteractsWithProtectedQualities;

class TestingConcernsTest extends TestCase
{
    use RefreshDatabase;
    use AuthenticatesUser;
    use InteractsWithNetwork;
    use InteractsWithProtectedQualities;

    public function testDetermineNetworkConnectionStatus()
    {
        $response = Http::get('www.example.com');

        if ($response->ok()) {
            $this->assertTrue($this->isConnected());
        } else {
            $this->assertFalse($this->isConnected());
        }
    }

    public function testAccessProtectedQualities()
    {
        $pstub = new ProtectedQualitiesStub();

        $this->assertEquals('foo', $this->accessProperty($pstub, 'prop'));
        $this->accessMethod($pstub, 'setProp', ['bar']);
        $this->assertEquals('bar', $this->accessProperty($pstub, 'prop'));
    }

    public function testCreateNewFakeUser()
    {
        $this->signIn($user = User::create([
            'name' => 'Thavarshan Thayananthajothy',
            'username' => 'Thavarshan',
            'email' => 'thavarshan@cratespace.biz',
            'phone' => '0712345678',
            'password' => Hash::make('secret-password'),
        ]));

        $this->assertTrue(Auth::check());
        $this->assertTrue(Auth::user()->is($user));
    }
}

class ProtectedQualitiesStub
{
    protected $prop = 'foo';

    protected function setProp(string $prop): void
    {
        $this->prop = $prop;
    }
}
