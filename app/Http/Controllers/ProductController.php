<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    protected $productService;
    protected $cartService;

    public function __construct(ProductService $productService, CartService $cartService)
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    public function index(Request $request)
    {
        $query = $request->get('search');
        $categoryId = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');

        if ($query) {
            $products = $this->productService->searchProducts($query, $minPrice, $maxPrice);
        } elseif ($categoryId) {
            $products = $this->productService->getProductsByCategory($categoryId, $minPrice, $maxPrice);
        } elseif ($minPrice || $maxPrice) {
            $products = $this->productService->getProductsByPriceRange($minPrice, $maxPrice);
        } else {
            $products = $this->productService->getAllProducts();
        }

        $categories = $this->productService->getAllCategories();

        $cartItemsCount = 0;
        if (Auth::check()) {
            $cartItemsCount = $this->cartService->getCartItemsCount(Auth::user());
        }

        return view('products.index', compact('products', 'categories', 'cartItemsCount', 'query', 'categoryId', 'minPrice', 'maxPrice'));
    }

    public function show($id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            abort(404, 'Sản phẩm không tồn tại');
        }

        $relatedProducts = $this->productService->getRelatedProducts($product, 4);

        $cartItemsCount = 0;
        $isInCart = false;
        $cartQuantity = 0;

        if (Auth::check()) {
            $cartItemsCount = $this->cartService->getCartItemsCount(Auth::user());
            $isInCart = $this->cartService->isProductInCart(Auth::user(), $product->id);
            if ($isInCart) {
                $cartItem = $this->cartService->getCartItemByProduct(Auth::user(), $product->id);
                $cartQuantity = $cartItem ? $cartItem->quantity : 0;
            }
        }

        return view('products.show', compact('product', 'relatedProducts', 'cartItemsCount', 'isInCart', 'cartQuantity'));
    }
}
