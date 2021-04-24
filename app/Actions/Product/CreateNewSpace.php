<?php

namespace App\Actions\Product;

use App\Support\Traits\Fillable;
use App\Contracts\Actions\CreatesNewResources;

class CreateNewSpace implements CreatesNewResources
{
    use Fillable;

    /**
     * Create new resource type.
     *
     * @param array       $data
     * @param string|null $resource
     *
     * @return mixed
     */
    public function create(array $data, ?string $resource = null)
    {
        return $resource::create($this->filterFillable($resource, $data));
    }
}
