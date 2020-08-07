<?php

namespace App\Contracts\Support;

interface Validator
{
    /**
     * Determine if the given item passes the given statndards.
     *
     * @param mixed $item
     * @param mixed $standard
     *
     * @return bool
     */
    public function validate($item, $standard): bool;
}
