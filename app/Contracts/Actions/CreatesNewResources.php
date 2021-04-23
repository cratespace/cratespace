<?php

namespace App\Contracts\Actions;

interface CreatesNewResources
{
    /**
     * Create new resource type.
     *
     * @param array       $data
     * @param string|null $resource
     *
     * @return mixed
     */
    public function create(array $data, ?string $resource = null);
}
