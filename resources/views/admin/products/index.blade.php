@extends('admin.layout')

@section('title', 'Quản lý sản phẩm')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Quản lý sản phẩm</h1>
        <a href="{{ route('admin.products.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
            <i class="fas fa-plus mr-2"></i>
            Thêm sản phẩm
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.products') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search by name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm theo tên</label>
                    <input type="text" name="name" value="{{ $filters['name'] ?? '' }}"
                           placeholder="Nhập tên sản phẩm..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Filter by category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Danh mục</label>
                    <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ ($filters['category'] ?? '') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Min price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Giá từ (VND)</label>
                    <input type="text" name="min_price" id="min_price"
                           value="{{ isset($filters['min_price']) && $filters['min_price'] ? number_format($filters['min_price'], 0, ',', '.') : '' }}"
                           placeholder="Nhập giá tối thiểu..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Max price -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Giá đến (VND)</label>
                    <input type="text" name="max_price" id="max_price"
                           value="{{ isset($filters['max_price']) && $filters['max_price'] ? number_format($filters['max_price'], 0, ',', '.') : '' }}"
                           placeholder="Nhập giá tối đa..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-search mr-2"></i>
                    Tìm kiếm
                </button>
                <a href="{{ route('admin.products') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Search Results Info -->
    @if(request()->hasAny(['search', 'category_id', 'min_price', 'max_price']))
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-filter text-blue-600 mr-2"></i>
                    <span class="text-blue-800 font-medium">
                        Đang hiển thị {{ $products->count() }} sản phẩm
                        @if($filters['search'])
                            với từ khóa "{{ $filters['search'] }}"
                        @endif
                        @if($filters['category_id'])
                            trong danh mục "{{ $categories->where('id', $filters['category_id'])->first()->name ?? '' }}"
                        @endif
                        @if($filters['min_price'] || $filters['max_price'])
                            với giá từ {{ $filters['min_price'] ? number_format($filters['min_price'], 0, ',', '.') . ' VND' : '0 VND' }}
                            đến {{ $filters['max_price'] ? number_format($filters['max_price'], 0, ',', '.') . ' VND' : 'không giới hạn' }}
                        @endif
                    </span>
                </div>
                <a href="{{ route('admin.products') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-times mr-1"></i>
                    Xóa bộ lọc
                </a>
            </div>
        </div>
    @endif

    <!-- Products Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sản phẩm</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Danh mục</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá bán</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Giá nhập</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tồn kho</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-12 w-12">
                                        @if($product->image_url)
                                            <img class="h-12 w-12 rounded-lg object-cover" src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}">
                                        @else
                                            <div class="h-12 w-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $product->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($product->description, 50) }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->category->name ?? 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-green-600">
                                {{ number_format($product->price, 0, ',', '.') }} VND
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->cost_price ? number_format($product->cost_price, 0, ',', '.') . ' VND' : 'N/A' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $product->stock_quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($product->stock_quantity > 0)
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Còn hàng
                                    </span>
                                @else
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Hết hàng
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="text-blue-600 hover:text-blue-900">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-box-open text-4xl mb-4"></i>
                                <p>Chưa có sản phẩm nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($products->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $products->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    // Format number with dots for thousands separator
    function formatNumberInput(input) {
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
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');

        if (minPriceInput) {
            minPriceInput.addEventListener('input', function() {
                formatNumberInput(this);
            });

            minPriceInput.addEventListener('blur', function() {
                formatNumberInput(this);
            });
        }

        if (maxPriceInput) {
            maxPriceInput.addEventListener('input', function() {
                formatNumberInput(this);
            });

            maxPriceInput.addEventListener('blur', function() {
                formatNumberInput(this);
            });
        }
    });

    // Format number inputs on page load
    document.addEventListener('DOMContentLoaded', function() {
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');

        if (minPriceInput && minPriceInput.value) {
            formatNumberInput(minPriceInput);
        }
        if (maxPriceInput && maxPriceInput.value) {
            formatNumberInput(maxPriceInput);
        }
    });
</script>
@endpush
@endsection
