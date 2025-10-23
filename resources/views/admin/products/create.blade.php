@extends('admin.layout')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="max-w-4xl">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Thêm sản phẩm mới</h1>
        <p class="text-gray-600 mt-1">Điền thông tin sản phẩm và tải lên ảnh</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                    Tên sản phẩm <span class="text-red-500">*</span>
                </label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('name') border-red-500 @enderror"
                       placeholder="Nhập tên sản phẩm" required>
                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Mô tả sản phẩm
                </label>
                <textarea id="description" name="description" rows="4"
                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('description') border-red-500 @enderror"
                          placeholder="Nhập mô tả sản phẩm">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Category and Image Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Category -->
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Danh mục <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('category_id') border-red-500 @enderror" required>
                        <option value="">Chọn danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Image Upload -->
                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                        Ảnh sản phẩm <span class="text-red-500">*</span>
                    </label>
                    <input type="file" id="image" name="image" accept="image/*"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('image') border-red-500 @enderror" required>
                    <p class="text-xs text-gray-500 mt-1">Định dạng: JPEG, PNG, JPG, GIF. Tối đa 2MB</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Price Row -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Selling Price -->
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá bán (VND) <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="price" name="price" value="{{ old('price') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('price') border-red-500 @enderror"
                           placeholder="Nhập giá bán" required>
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cost Price -->
                <div>
                    <label for="cost_price" class="block text-sm font-medium text-gray-700 mb-2">
                        Giá nhập (VND)
                    </label>
                    <input type="text" id="cost_price" name="cost_price" value="{{ old('cost_price') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('cost_price') border-red-500 @enderror"
                           placeholder="Nhập giá nhập">
                    @error('cost_price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Stock Quantity -->
            <div>
                <label for="stock_quantity" class="block text-sm font-medium text-gray-700 mb-2">
                    Số lượng tồn kho <span class="text-red-500">*</span>
                </label>
                <input type="number" id="stock_quantity" name="stock_quantity" value="{{ old('stock_quantity') }}" min="0"
                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('stock_quantity') border-red-500 @enderror"
                       placeholder="Nhập số lượng tồn kho" required>
                @error('stock_quantity')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.products') }}" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-medium transition-colors">
                    Hủy
                </a>
                <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition-colors">
                    <i class="fas fa-save mr-2"></i>
                    Thêm sản phẩm
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Format number with dots for thousands separator
    function formatNumber(input) {
        // Remove all non-numeric characters
        let value = input.value.replace(/[^\d]/g, '');

        // Add dots for thousands separator
        if (value.length > 0) {
            value = parseInt(value).toLocaleString('vi-VN');
        }

        input.value = value;
    }

    // Add event listeners for price inputs
    document.addEventListener('DOMContentLoaded', function() {
        const priceInput = document.getElementById('price');
        const costPriceInput = document.getElementById('cost_price');

        if (priceInput) {
            priceInput.addEventListener('input', function() {
                formatNumber(this);
            });

            // Format on focus out
            priceInput.addEventListener('blur', function() {
                formatNumber(this);
            });
        }

        if (costPriceInput) {
            costPriceInput.addEventListener('input', function() {
                formatNumber(this);
            });

            // Format on focus out
            costPriceInput.addEventListener('blur', function() {
                formatNumber(this);
            });
        }
    });
</script>
@endpush
@endsection
