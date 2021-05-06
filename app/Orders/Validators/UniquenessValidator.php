<?php

namespace App\Orders\Validators;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use App\Contracts\Orders\ConfirmationNumberValidator;

class UniquenessValidator implements ConfirmationNumberValidator
{
    /**
     * Validate the given order confirmation number.
     *
     * @param string $confirmationNumber
     *
     * @return bool
     */
    public function validate(string $confirmationNumber): bool
    {
        $numbers = DB::table('orders')
            ->get()
            ->pluck('confirmation_number')
            ->map(fn (string $number): bool => $number === $confirmationNumber)
            ->count();

        return ($numbers > 1) ? false : true;
    }
}
