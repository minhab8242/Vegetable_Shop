<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
    ];

    /**
     * Get the user that owns the cart.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product for the cart.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the subtotal for the cart item.
     */
    public function getSubtotalAttribute(): float
    {
        return $this->product->price * $this->quantity;
    }

    /**
     * Get formatted subtotal.
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return '₫' . number_format($this->subtotal, 0, ',', '.');
    }
}
