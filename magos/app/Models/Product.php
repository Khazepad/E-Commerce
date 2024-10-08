<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_name',
        'description',
        'price',
        'stock',
        'image',
        'is_discontinued'
    ];


    /**
     * Define a relationship with the Category model.
     * Assuming a product belongs to one category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Define a relationship with the Supplier model.
     * Assuming a product belongs to one supplier.
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Calculate the discounted price of the product.
     *
     * @param float $discountPercentage
     * @return float
     */
    public function calculateDiscountedPrice(float $discountPercentage): float
    {
        return $this->price - ($this->price * ($discountPercentage / 100));
    }

    /**
     * Check if the product is in stock.
     *
     * @return bool
     */
    public function isInStock(): bool
    {
        return $this->stock > 0;
    }

    /**
     * Decrease the stock of the product.
     *
     * @param int $quantity
     * @return bool
     */
    public function decreaseStock(int $quantity): bool
    {
        if ($this->stock >= $quantity) {
            $this->stock -= $quantity;
            $this->save();
            return true;
        }
        return false;
    }

    /**
     * Increase the stock of the product.
     *
     * @param int $quantity
     * @return void
     */
    public function increaseStock(int $quantity): void
    {
        $this->stock += $quantity;
        $this->save();
    }

    /**
     * Check if the product is low in stock.
     *
     * @param int $threshold
     * @return bool
     */
    public function isLowStock(int $threshold = 10): bool
    {
        return $this->stock <= $threshold;
    }

    /**
     * Define a relationship with the Stock model.
     * Assuming a product has one stock.
     */
    public function stock()
    {
        return $this->hasOne(Stock::class);
    }
}