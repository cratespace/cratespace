<?php

namespace App\Actions\Purchases;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ValidatePurchaseToken
{
    /**
     * Validate the given purchase token.
     *
     * @param string $token
     *
     * @return bool
     */
    public function validate(?string $token = null): bool
    {
        $value = DB::table('purchase_tokens')
            ->where('token', $token)
            ->first();

        if (! is_null($value)) {
            return Hash::check($value->name, $token);
        }

        return false;
    }
}
