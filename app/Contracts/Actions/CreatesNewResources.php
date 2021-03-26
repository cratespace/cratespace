<?php

namespace App\Contracts\Actions;

interface CreatesNewResources
{
    /**
     * Create a new resource.
     *
     * @param string $model
     * @param array  $data
     *
     * @return mixed
     */
    public function create(string $model, array $data);
}
