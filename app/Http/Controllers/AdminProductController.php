<?php

namespace App\Http\Controllers;

use App\Services\AdminProductService;
use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    protected $productService;

    public function __construct(AdminProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        $filters = [
            'name' => $request->get('name', ''),
            'category' => $request->get('category', ''),
            'min_price' => $request->get('min_price', ''),
            'max_price' => $request->get('max_price', ''),
        ];

        $products = $this->productService->getAllProducts($filters);
        $categories = $this->productService->getAllCategories();
        return view('admin.products.index', compact('products', 'categories', 'filters'));
    }

    public function create()
    {
        $categories = $this->productService->getAllCategories();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->productService->processFormattedNumbers($request);

        $request->validate(
            $this->productService->getValidationRules(false),
            $this->productService->getValidationMessages()
        );

        $imagePath = $this->productService->handleImageUpload($request);

        $this->productService->createProduct([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('admin.products')->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = $this->productService->getProductById($id);
        $categories = $this->productService->getAllCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $this->productService->processFormattedNumbers($request);

        $request->validate(
            $this->productService->getValidationRules(true),
            $this->productService->getValidationMessages()
        );

        $product = $this->productService->getProductById($id);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'cost_price' => $request->cost_price,
            'stock_quantity' => $request->stock_quantity,
            'category_id' => $request->category_id,
        ];

        if ($request->hasFile('image')) {
            $this->productService->deleteOldImage($product);
            $imagePath = $this->productService->handleImageUpload($request);
            $data['image_url'] = $imagePath;
        }

        $this->productService->updateProduct($product, $data);

        return redirect()->route('admin.products')->with('success', 'Cập nhật sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $product = $this->productService->getProductById($id);
        $this->productService->deleteProduct($product);

        return redirect()->route('admin.products')->with('success', 'Xóa sản phẩm thành công!');
    }
}
