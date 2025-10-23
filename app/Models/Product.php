<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'cost_price',
        'stock_quantity',
        'image_url',
        'sales_count',
        'rating',
        'review_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'cost_price' => 'decimal:2',
        ];
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the carts for the product.
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the order details for the product.
     */
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₫' . number_format($this->price, 0, ',', '.');
    }

    public function getFormattedRatingAttribute(): string
    {
        return number_format($this->rating, 1);
    }

    public function getFormattedSalesAttribute(): string
    {
        if ($this->sales_count >= 1000) {
            return number_format($this->sales_count / 1000, 1) . 'k';
        }
        return number_format($this->sales_count);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->stock_quantity == 0) {
            return 'Hết hàng';
        } elseif ($this->stock_quantity <= 5) {
            return 'Sắp hết hàng';
        } else {
            return 'Còn hàng';
        }
    }

    public function getStockStatusColorAttribute(): string
    {
        if ($this->stock_quantity == 0) {
            return 'red';
        } elseif ($this->stock_quantity <= 5) {
            return 'orange';
        } else {
            return 'green';
        }
    }

    /**
     * Get average rating from reviews.
     */
    public function getAverageRating(): float
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    /**
     * Get total review count.
     */
    public function getTotalReviews(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Get rating distribution.
     */
    public function getRatingDistribution(): array
    {
        $distribution = [];
        for ($i = 1; $i <= 5; $i++) {
            $distribution[$i] = $this->reviews()->where('rating', $i)->count();
        }
        return $distribution;
    }

    /**
     * Get recent reviews.
     */
    public function getRecentReviews($limit = 5)
    {
        return $this->reviews()->with('user')->orderBy('created_at', 'desc')->limit($limit)->get();
    }
}
