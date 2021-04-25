<?php

namespace App\Actions\Products;

use App\Products\Factories\SpaceFactory;
use App\Contracts\Actions\CreatesNewResources;

class CreateNewSpace implements CreatesNewResources
{
    /**
     * The space factory instance.
     *
     * @var \App\Products\Factories\SpaceFactory
     */
    protected $factory;

    /**
     * Create new instance of create new space action class.
     *
     * @param \App\Products\Factories\SpaceFactory $factory
     *
     * @return void
     */
    public function __construct(SpaceFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Create new resource type.
     *
     * @param array $data
     *
     * @return mixed
     */
    public function create(array $data)
    {
        return $this->factory->make($data);
    }
}
