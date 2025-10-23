<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_description',
        'price',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    /**
     * Get the order that owns the order detail.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the product for the order detail (optional, for reference only).
     * Note: Product information is stored in snapshot fields.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted price.
     */
    public function getFormattedPriceAttribute(): string
    {
        return '₫' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get formatted subtotal.
     */
    public function getFormattedSubtotalAttribute(): string
    {
        return '₫' . number_format($this->subtotal, 0, ',', '.');
    }
}
