<?php

namespace App\Services\Stripe;

use App\Facades\Stripe;
use Stripe\ApiResource;
use Illuminate\Support\Collection;
use Stripe\Service\AbstractService;
use Symfony\Component\Translation\Exception\InvalidResourceException;

abstract class Resource
{
    /**
     * The resource instance.
     *
     * @var \Stripe\ApiResource
     */
    protected $resource;

    /**
     * Resource index for usage with Stripe.
     *
     * @var string
     */
    protected static $index;

    /**
     * Resource specific attributes.
     *
     * @var array
     */
    protected static $attributes;

    /**
     * Create new instance of Stripe API resource.
     *
     * @param \Stripe\ApiResource|string $resource
     *
     * @return void
     */
    public function __construct($resource)
    {
        if (is_string($resource)) {
            $resource = static::getStripeObject($resource);
        }

        $this->resource = $resource;
    }

    /**
     * Get all resource objects as list.
     *
     * @param array $filters
     *
     * @return \Illuminate\Support\Collection
     */
    public static function all(array $filters = null): Collection
    {
        $data = static::createService()->all($filters)->data;

        if (empty($data)) {
            return collect([]);
        }

        return collect($data)->map(fn ($resource) => new static($resource));
    }

    /**
     * Get the specified Stripe resource.
     *
     * @param string $id
     *
     * @return \App\Services\Stripe\Resource
     */
    public static function get(string $id): Resource
    {
        return new static(static::getStripeObject($id));
    }

    /**
     * Get the specified Stripe resource.
     *
     * @param string $id
     *
     * @return \Stripe\ApiResource
     */
    public static function getStripeObject(string $id): ApiResource
    {
        return static::createService()->retrieve($id);
    }

    /**
     * Create new Stripe customer.
     *
     * @param array $data
     *
     * @return \Stripe\ApiResource
     */
    public static function create(array $data): ApiResource
    {
        return static::createService()->create(static::fillable($data));
    }

    /**
     * Update specified resource.
     *
     * @param string $id
     *
     * @return void
     */
    public function update(array $data): void
    {
        static::createService()->update($this->id, static::fillable($data));
    }

    /**
     * Delete specified resource.
     *
     * @param string $id
     *
     * @return void
     */
    public function delete(): void
    {
        static::createService()->delete($this->id);
    }

    /**
     * Create instance of resource specific service provider.
     *
     * @return \Stripe\AbstractService
     */
    protected static function createService(): AbstractService
    {
        if (! is_null(static::$index)) {
            return Stripe::{static::$index}();
        }

        throw new InvalidResourceException('Resource index has not been set');
    }

    /**
     * Filter out only allowable attributes of the resource.
     *
     * @param array $data
     *
     * @return array
     */
    public static function fillable(array $data): array
    {
        return array_filter($data, function (string $key): bool {
            return in_array($key, static::$attributes);
        }, \ARRAY_FILTER_USE_KEY);
    }

    /**
     * Refresh the resource instance.
     *
     * @return void
     */
    public function refresh(): void
    {
        $this->resource = static::get($this->id);
    }

    /**
     * Dynamically get values from the Stripe resource.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get(string $key)
    {
        return $this->resource->{$key};
    }
}
