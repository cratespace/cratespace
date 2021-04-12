<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use App\Contracts\Billing\Product as ProductContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'code',
        'productable_id',
        'productable_type',
        'details',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'details' => 'array',
    ];

    /**
     * Get the model belonging to the product.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function productable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Determine if the given product is already stored.
     *
     * @param \App\Contracts\Billing\Product $product
     *
     * @return bool
     */
    public function has(ProductContract $product): bool
    {
        return static::all()->contains(
            fn (Product $item): bool => $item->code === $product->code()
        );
    }

    /**
     * Find a product registration using the given product code.
     *
     * @param string $code
     *
     * @return \App\Models\Product|null
     */
    public function findUsingCode(string $code): ?Product
    {
        return static::whereCode($code)->first();
    }
}
