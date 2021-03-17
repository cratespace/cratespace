<?php

namespace App\Actions\Purchases;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Cratespace\Sentinel\Contracts\Codes\CodeGenerator;

class GeneratePurchaseToken implements CodeGenerator
{
    /**
     * Generate a new and unique code.
     *
     * @return string
     */
    public function generate(): string
    {
        $token = Hash::make($name = func_get_arg(0));

        DB::table('purchase_tokens')->insert(compact('name', 'token'));

        return $token;
    }
}
