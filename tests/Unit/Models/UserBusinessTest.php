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
            'name' => $data['business'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'registration_number' => $data['registration_number'],
            'business_type' => 'company',
            'business_profile' => [
                'name' => $data['business'],
                'mcc' => $data['mcc'] ?? null,
                'support_phone' => $data['phone'],
                'support_email' => $data['email'],
                'url' => $data['url'] ?? null,
            ],
        ]);

        $this->assertInstanceOf(Business::class, $user->business);
        $this->assertDatabaseHas('businesses', ['name' => 'Example, Inc.']);
    }
}
