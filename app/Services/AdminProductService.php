<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProductService
{
    public function getAllProducts($filters = [], $perPage = 10)
    {
        $query = Product::with('category');

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        if (!empty($filters['min_price'])) {
            // Convert formatted price to number
            $minPrice = str_replace(['.', ','], '', $filters['min_price']);
            $query->where('price', '>=', $minPrice);
        }
        if (!empty($filters['max_price'])) {
            // Convert formatted price to number
            $maxPrice = str_replace(['.', ','], '', $filters['max_price']);
            $query->where('price', '<=', $maxPrice);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getAllCategories()
    {
        return Category::all();
    }

    public function getProductById($id)
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $data)
    {
        return Product::create($data);
    }

    public function updateProduct(Product $product, array $data)
    {
        return $product->update($data);
    }

    public function deleteProduct(Product $product)
    {
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }

        return $product->delete();
    }

    public function handleImageUpload(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();
            return $image->storeAs('products', $imageName, 'public');
        }
        return null;
    }

    public function deleteOldImage(Product $product)
    {
        if ($product->image_url && Storage::disk('public')->exists($product->image_url)) {
            Storage::disk('public')->delete($product->image_url);
        }
    }

    public function processFormattedNumbers(Request $request)
    {
        $request->merge([
            'price' => str_replace('.', '', $request->price),
            'cost_price' => $request->cost_price ? str_replace('.', '', $request->cost_price) : null,
        ]);
    }

    public function getValidationRules($isUpdate = false)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
        ];

        if ($isUpdate) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        } else {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }

    public function getValidationMessages()
    {
        return [
            'name.required' => 'Vui lòng nhập tên sản phẩm.',
            'name.max' => 'Tên sản phẩm không được vượt quá :max ký tự.',
            'price.required' => 'Vui lòng nhập giá bán.',
            'price.numeric' => 'Giá bán phải là số.',
            'price.min' => 'Giá bán phải lớn hơn hoặc bằng 0.',
            'cost_price.numeric' => 'Giá nhập phải là số.',
            'cost_price.min' => 'Giá nhập phải lớn hơn hoặc bằng 0.',
            'stock_quantity.required' => 'Vui lòng nhập số lượng tồn kho.',
            'stock_quantity.integer' => 'Số lượng tồn kho phải là số nguyên.',
            'stock_quantity.min' => 'Số lượng tồn kho phải lớn hơn hoặc bằng 0.',
            'category_id.required' => 'Vui lòng chọn danh mục.',
            'category_id.exists' => 'Danh mục không tồn tại.',
            'image.required' => 'Vui lòng chọn ảnh sản phẩm.',
            'image.image' => 'File phải là ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng: jpeg, png, jpg, gif.',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB.',
        ];
    }
}
