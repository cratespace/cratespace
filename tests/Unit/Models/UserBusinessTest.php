<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserBusinessTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateBusinessProfileForUser()
    {
        $user = create(User::class);

        $user->createAsBusiness([
            'type' => 'standard',
            'business' => 'Example, Inc.',
            'email' => $user->email,
            'phone' => $user->phone,
            'registration_number' => 1234567,
            'business_type' => 'company',
            'business_profile' => [
                'name' => 'Example, Inc.',
                'mcc' => 1234,
                'support_phone' => $user->phone,
                'support_email' => $user->email,
                'url' => 'www.example.com',
            ],
        ]);

        $this->assertInstanceOf(Business::class, $user->business);
        $this->assertDatabaseHas('businesses', ['name' => 'Example, Inc.']);
    }
}
