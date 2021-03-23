<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\User;
use App\Models\Business;
use App\Models\Values\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BusinessTest extends TestCase
{
    use RefreshDatabase;

    public function testBelongsToUser()
    {
        $business = create(Business::class);

        $this->assertInstanceOf(User::class, $business->user);
    }

    public function testBusinessProfileCastsAsArrayObject()
    {
        $business = create(Business::class);

        $this->assertInstanceOf(Profile::class, $business->business_profile);
    }
}
