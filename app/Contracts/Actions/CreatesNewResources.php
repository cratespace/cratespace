<?php

namespace App\Contracts\Actions;

interface CreatesNewResources
{
    /**
     * Create a new resource.
     *
     * @param mixed $resource
     * @param array $data
     *
     * @return mixed
     */
    public function create($resource, array $data);
}
