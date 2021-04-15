<?php

namespace Tests\Concerns;

use ReflectionClass;

trait InteractsWithProtectedQualities
{
    /**
     * Grant access to protected/private class property.
     *
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    protected function accessProperty(object $object, string $property)
    {
        $property = $this->reflection($object)->getProperty($property);

        $property->setAccessible(true);

        return $property->getValue($object);
    }

    /**
     * Grant access to protected/private class methods.
     *
     * @param object  $object
     * @param string  $method
     * @param array[] $parameters
     *
     * @return mixed
     */
    protected function accessMethod(object $object, string $method, array $parameters = [])
    {
        $method = $this->reflection($object)->getMethod($method);

        $method->setAccessible(true);

        return $method->invokeArgs($object, $parameters);
    }

    /**
     * Create new instance of reflection class with given object as parameter.
     *
     * @param object $object
     *
     * @return \ReflectionClass
     */
    protected function reflection(object $object): ReflectionClass
    {
        return new ReflectionClass($object);
    }
}
