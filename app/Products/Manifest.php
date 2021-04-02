<?php

namespace App\Products;

use App\Models\Space;
use App\Exceptions\InvalidResourceException;

class Manifest
{
    /**
     * List of product classes.
     *
     * @param array
     */
    protected $productClasses = [
        Space::class,
    ];

    /**
     * Match a givel product class name to.
     *
     * @param string $class
     *
     * @return string
     */
    public function validateProductClass(string $class): string
    {
        if (in_array($class, $this->productClasses)) {
            return $class;
        }

        throw new InvalidResourceException("Product class with [$class] name does not exist");
    }
}
