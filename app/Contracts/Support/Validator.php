<?php

namespace App\Contracts\Support;

interface Validator
{
    /**
     * Determine if the given item passes the given standards.
     *
     * @param mixed      $item
     * @param array|null $options
     *
     * @return bool
     */
    public function validate($item, ?array $options = null): bool;
}
