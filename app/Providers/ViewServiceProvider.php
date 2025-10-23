<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Services\CartService;

class ViewServiceProvider extends ServiceProvider
{
    protected $cartService;

    public function __construct()
    {
        $this->cartService = app(CartService::class);
    }

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share cart items count with all views
        View::composer('*', function ($view) {
            $cartItemsCount = 0;

            if (Auth::check()) {
                $cartItemsCount = $this->cartService->getCartItemsCount(Auth::user());
            }

            $view->with('cartItemsCount', $cartItemsCount);
        });
    }
}
