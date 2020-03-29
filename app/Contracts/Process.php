<?php

namespace App\Contracts;

interface Process
{
    /**
     * Process given data and follow relevant procedures.
     *
     * @param  array $value
     * @return void
     */
    public function perform(array $data);
}
