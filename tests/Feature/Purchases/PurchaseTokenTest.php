<?php

namespace Tests\Feature\Purchases;

use Tests\TestCase;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Actions\Purchases\GeneratePurchaseToken;
use App\Actions\Purchases\ValidatePurchaseToken;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchaseTokenTest extends TestCase
{
    use RefreshDatabase;

    public function testTokenGeneration()
    {
        $productCode = Str::random(40);
        $generator = new GeneratePurchaseToken();

        $token = $generator->generate($productCode);
        Hash::check($productCode, $token);
        $this->assertEquals(1, (DB::table('purchase_tokens')->count()));
    }

    public function testValidateToken()
    {
        $productCode = Str::random(40);
        $generator = new GeneratePurchaseToken();
        $validator = new ValidatePurchaseToken();

        $token = $generator->generate($productCode);
        $nonExistantToken = Str::random(20);
        $this->assertTrue($validator->validate($token));
        $this->assertFalse($validator->validate($nonExistantToken));
    }
}
