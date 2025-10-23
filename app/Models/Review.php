<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'rating',
        'comment',
        'title',
        'is_verified_purchase',
        'is_helpful',
        'helpful_count',
        'images',
    ];

    protected function casts(): array
    {
        return [
            'is_verified_purchase' => 'boolean',
            'is_helpful' => 'boolean',
            'images' => 'array',
        ];
    }

    /**
     * Get the user that owns the review.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the product that owns the review.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get formatted rating.
     */
    public function getFormattedRatingAttribute(): string
    {
        return number_format($this->rating, 1);
    }

    /**
     * Get formatted date.
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at->format('d/m/Y');
    }

    /**
     * Get short comment.
     */
    public function getShortCommentAttribute(): string
    {
        return \Str::limit($this->comment, 100);
    }

    /**
     * Scope for verified purchases.
     */
    public function scopeVerified($query)
    {
        return $query->where('is_verified_purchase', true);
    }

    /**
     * Scope for helpful reviews.
     */
    public function scopeHelpful($query)
    {
        return $query->where('is_helpful', true);
    }

    /**
     * Scope for rating.
     */
    public function scopeRating($query, $rating)
    {
        return $query->where('rating', $rating);
    }

    /**
     * Scope for recent reviews.
     */
    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }
}
