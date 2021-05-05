<?php

namespace App\Exceptions;

use Exception;

abstract class AccountAlreadyCreated extends Exception
{
    /**
     * Create a new AccountAlreadyCreated instance.
     *
     * @param string $id
     *
     * @return \App\Exceptions\AccountAlreadyCreated
     */
    public static function exists(string $id): AccountAlreadyCreated
    {
        return new static("User with ID {$id} is already a registered account");
    }
}
