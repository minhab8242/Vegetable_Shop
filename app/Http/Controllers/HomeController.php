<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    protected $productService;
    protected $cartService;

    public function __construct(ProductService $productService, CartService $cartService)
    {
        $this->productService = $productService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $featuredProducts = $this->productService->getFeaturedProducts(8);
        $categories = $this->productService->getAllCategories();
        $latestProducts = $this->productService->getLatestProducts(6);

        $cartItemsCount = 0;
        if (Auth::check()) {
            $cartItemsCount = $this->cartService->getCartItemsCount(Auth::user());
        }

        return view('home', compact('featuredProducts', 'categories', 'latestProducts', 'cartItemsCount'));
    }
}
