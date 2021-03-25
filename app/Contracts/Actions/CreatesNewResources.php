<?php

namespace App\Contracts\Actions;

use Illuminate\Database\Eloquent\Model;

interface CreatesNewResources
{
    /**
     * Create a new resource.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array                               $data
     *
     * @return mixed
     */
    public function create(Model $model, array $data);
}
