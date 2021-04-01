<?php

namespace App\Contracts\Actions;

interface CreatesNewResources
{
    /**
     * Create a new resource.
     *
     * @param mixed $model
     * @param array  $data
     *
     * @return mixed
     */
    public function create($model, array $data);
}
