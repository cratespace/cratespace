<?php

namespace App\Contracts\Actions;

interface CreatesNewResources
{
    /**
     * Create new resource type.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data);
}
