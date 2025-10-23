<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReviewController extends Controller
{

    public function store(Request $request, Product $product)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để đánh giá sản phẩm'
            ], 401);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        $hasPurchased = $this->checkVerifiedPurchase($user, $product);
        if (!$hasPurchased) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn cần mua sản phẩm này trước khi có thể đánh giá.'
            ], 403);
        }

        $existingReview = Review::where('user_id', $user->id)
            ->where('product_id', $product->id)
            ->first();

        if ($existingReview) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn đã đánh giá sản phẩm này rồi'
            ], 400);
        }

        $review = Review::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
            'is_verified_purchase' => $this->checkVerifiedPurchase($user, $product),
        ]);

        $this->updateProductRating($product);

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá đã được thêm thành công',
            'review' => $review->load('user')
        ]);
    }

    public function update(Request $request, Review $review)
    {
        if (!Auth::check() || Auth::id() !== $review->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền chỉnh sửa đánh giá này'
            ], 403);
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'title' => 'nullable|string|max:255',
            'comment' => 'nullable|string|max:1000',
        ]);

        $review->update([
            'rating' => $request->rating,
            'title' => $request->title,
            'comment' => $request->comment,
        ]);

        $this->updateProductRating($review->product);

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá đã được cập nhật thành công',
            'review' => $review->load('user')
        ]);
    }

    public function destroy(Review $review)
    {
        if (!Auth::check() || Auth::id() !== $review->user_id) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền xóa đánh giá này'
            ], 403);
        }

        $product = $review->product;
        $review->delete();

        $this->updateProductRating($product);

        return response()->json([
            'success' => true,
            'message' => 'Đánh giá đã được xóa thành công'
        ]);
    }

    public function getProductReviews(Product $product, Request $request)
    {
        $perPage = $request->get('per_page', 10);
        $rating = $request->get('rating');
        $sort = $request->get('sort', 'recent');

        $query = $product->reviews()->with('user');

        if ($rating) {
            $query->where('rating', $rating);
        }

        switch ($sort) {
            case 'helpful':
                $query->orderBy('helpful_count', 'desc');
                break;
            case 'rating':
                $query->orderBy('rating', 'desc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
        }

        $reviews = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'reviews' => $reviews,
            'rating_distribution' => $product->getRatingDistribution(),
            'average_rating' => $product->getAverageRating(),
            'total_reviews' => $product->getTotalReviews()
        ]);
    }

    public function markHelpful(Review $review)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để đánh giá hữu ích'
            ], 401);
        }

        $newIsHelpful = !$review->is_helpful;
        $newHelpfulCount = $newIsHelpful
            ? $review->helpful_count + 1
            : max(0, $review->helpful_count - 1);

        $review->update([
            'is_helpful' => $newIsHelpful,
            'helpful_count' => $newHelpfulCount,
        ]);

        return response()->json([
            'success' => true,
            'message' => $newIsHelpful ? 'Đánh giá hữu ích' : 'Đã bỏ đánh giá hữu ích',
            'helpful_count' => $newHelpfulCount,
            'is_helpful' => (bool) $newIsHelpful,
        ]);
    }

    private function checkVerifiedPurchase($user, $product): bool
    {
        return $user->orders()
            ->whereHas('orderDetails', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->where('status', 'completed')
            ->exists();
    }

    private function updateProductRating(Product $product): void
    {
        $averageRating = $product->reviews()->avg('rating');
        $reviewCount = $product->reviews()->count();

        $product->update([
            'rating' => round($averageRating, 2),
            'review_count' => $reviewCount
        ]);
    }
}
