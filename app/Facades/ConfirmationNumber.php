<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;
use App\Orders\ConfirmationNumber as ConfirmationNumberManager;

class ConfirmationNumber extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ConfirmationNumberManager::class;
    }
}
