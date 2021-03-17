<?php

namespace App\Exceptions;

use Stripe\ApiResource;
use InvalidArgumentException;
use Illuminate\Database\Eloquent\Model;

class InvalidResourceException extends InvalidArgumentException
{
    /**
     * Create a new InvalidResourceException instance.
     *
     * @param \Stripe\ApiResource                 $resource
     * @param \Illuminate\Database\Eloquent\Model $owner
     *
     * @return \App\Exceptions\InvalidResourceException
     */
    public static function invalidOwner(ApiResource $resource, Model $owner): InvalidResourceException
    {
        return new static(
            "The resource `{$resource->id}` does not belong to this customer `$owner->stripe_id`."
        );
    }
}
