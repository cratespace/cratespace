<?php

namespace App\Actions\Business;

use App\Products\Factories\SpaceFactory;
use Cratespace\Sentinel\Contracts\Actions\CreatesNewResource;

class CreateNewSpace implements CreatesNewResource
{
    /**
     * The SpaceFactory instance.
     *
     * @var \App\Products\Factories\SpaceFactory
     */
    protected $factory;

    /**
     * Create new CreateNewSpace action class instance.
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
     * Create a new resource type.
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
