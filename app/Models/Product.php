<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
    protected $fillable = ['code', 'product_id', 'class'];

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
