<?php

namespace App\Http\View\Composers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\View\View;

class HeaderComposer
{

    public function compose(View $view): void
    {
        $categories = Category::withCount(['products' => function($query) {
            $query->where('stock_quantity', '>', 0);
        }])->orderBy('name')->get();

        $totalProducts = Product::where('stock_quantity', '>', 0)->count();

        $view->with([
            'headerCategories' => $categories,
            'totalProducts' => $totalProducts
        ]);
    }
}

