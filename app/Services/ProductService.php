<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{

    public function getFeaturedProducts(int $limit = 8): Collection
    {
        return Product::with('category')
            ->where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getAllProducts(int $perPage = 12): LengthAwarePaginator
    {
        return Product::with('category')
            ->where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    }

    public function getProductsByCategory(int $categoryId, $minPrice = null, $maxPrice = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with('category')
            ->where('category_id', $categoryId)
            ->where('stock_quantity', '>', 0);

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getProductById(int $id): ?Product
    {
        return Product::with('category')->find($id);
    }

    public function searchProducts(string $query, $minPrice = null, $maxPrice = null, int $perPage = 12): LengthAwarePaginator
    {
        $productQuery = Product::with('category')
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('description', 'like', "%{$query}%");
            })
            ->where('stock_quantity', '>', 0);

        if ($minPrice) {
            $productQuery->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $productQuery->where('price', '<=', $maxPrice);
        }

        return $productQuery->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getAllCategories(): Collection
    {
        return Category::withCount('products')
            ->orderBy('name')
            ->get();
    }

    public function getCategoryById(int $id): ?Category
    {
        return Category::find($id);
    }

    public function getRelatedProducts(Product $product, int $limit = 4): Collection
    {
        return Product::with('category')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('stock_quantity', '>', 0)
            ->limit($limit)
            ->get();
    }

    public function getProductsByPriceRange($minPrice = null, $maxPrice = null, int $perPage = 12): LengthAwarePaginator
    {
        $query = Product::with('category')
            ->where('stock_quantity', '>', 0);

        if ($minPrice) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->orderBy('price', 'asc')->paginate($perPage);
    }

    public function getLatestProducts(int $limit = 6): Collection
    {
        return Product::with('category')
            ->where('stock_quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
