<?php

abstract class Merchant
{
    protected $name;
    protected $address = [];
    protected $business = [];

    public function __construct(string $name, array $address, array $business)
    {
        $this->name = $name;
        $this->address = $address;
        $this->business = $business;
    }

    public function name(): string
    {
        return $this->name;
    }

    public function address(): object
    {
        return (object) $this->address;
    }

    public function business(): object
    {
        return (object) $this->address;
    }
}
