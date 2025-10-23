<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;

class AdminCategoryService
{
    public function getAllCategories($perPage = 10, $filters = [])
    {
        $query = Category::withCount('products');

        if (!empty($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }

    public function getCategoryById($id)
    {
        return Category::findOrFail($id);
    }

    public function createCategory(array $data)
    {
        return Category::create($data);
    }

    public function updateCategory(Category $category, array $data)
    {
        return $category->update($data);
    }

    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }

    public function getValidationRules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string|max:1000',
        ];
    }

    public function getValidationMessages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên danh mục.',
            'name.max' => 'Tên danh mục không được vượt quá :max ký tự.',
            'name.unique' => 'Tên danh mục đã tồn tại.',
            'description.max' => 'Mô tả không được vượt quá :max ký tự.',
        ];
    }

    public function getUpdateValidationRules($categoryId)
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name,' . $categoryId,
            'description' => 'nullable|string|max:1000',
        ];
    }
}
