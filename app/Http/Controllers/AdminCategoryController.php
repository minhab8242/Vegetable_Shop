<?php

namespace App\Http\Controllers;

use App\Services\AdminCategoryService;
use Illuminate\Http\Request;

class AdminCategoryController extends Controller
{
    protected $categoryService;

    public function __construct(AdminCategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
        ];

        $categories = $this->categoryService->getAllCategories(10, $filters);

        return view('admin.categories.index', compact('categories', 'filters'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            $this->categoryService->getValidationRules(),
            $this->categoryService->getValidationMessages()
        );

        $this->categoryService->createCategory([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Thêm danh mục thành công!');
    }

    public function edit($id)
    {
        $category = $this->categoryService->getCategoryById($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            $this->categoryService->getUpdateValidationRules($id),
            $this->categoryService->getValidationMessages()
        );

        $category = $this->categoryService->getCategoryById($id);

        $this->categoryService->updateCategory($category, [
            'name' => $request->name,
            'description' => $request->description,
        ]);

        return redirect()->route('admin.categories')->with('success', 'Cập nhật danh mục thành công!');
    }

    public function destroy($id)
    {
        $category = $this->categoryService->getCategoryById($id);

        // Check if category has products
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories')->with('error', 'Không thể xóa danh mục có sản phẩm!');
        }

        $this->categoryService->deleteCategory($category);

        return redirect()->route('admin.categories')->with('success', 'Xóa danh mục thành công!');
    }
}

