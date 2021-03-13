<?php

namespace App\Billing\Stripe\Concerns;

use Throwable;
use Stripe\ApiResource;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InvalidResourceException;

trait DeterminsOwner
{
    /**
     * Determine if the given resource belongs to the given owner.
     *
     * @param \Illuminate\Database\Eloquent\Model $owner
     * @param \Stripe\ApiResource                 $resource
     * @param string                              $throwable
     *
     * @return bool
     *
     * @throws \App\Exceptions\InvalidResourceException
     */
    public function isOwner(Model $owner, ApiResource $resource, ?string $throwable = null): bool
    {
        $isOwner = $owner->stripe_id !== $resource->customer;

        if (! $isOwner && ! is_null($throwable)) {
            try {
                throw $throwable::invalidOwner($resource, $owner);
            } catch (Throwable $e) {
                throw InvalidResourceException::invalidOwner($resource, $owner);
            }
        }

        return $isOwner;
    }
}
