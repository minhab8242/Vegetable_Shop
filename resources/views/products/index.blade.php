@extends('layouts.app')

@section('title', 'Sản phẩm - Vegetable Store')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <!-- Header -->
    <div class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">

                <!-- Search and Filter -->
                <div class="mt-4 lg:mt-0 flex flex-col sm:flex-row gap-4">
                    <!-- Search -->
                    <form method="GET" action="{{ route('products.index') }}" class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" value="{{ $query }}"
                                   placeholder="Tìm kiếm sản phẩm..."
                                   class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </form>

                </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar -->
            <div class="lg:w-1/4">
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Bộ lọc</h3>

                    <!-- Categories -->
                    <div class="mb-6">
                        <h4 class="font-medium text-gray-900 mb-3">Danh mục</h4>
                        <div class="space-y-2">
                            <a href="{{ route('products.index') }}"
                               class="block text-sm text-gray-600 hover:text-green-600 transition-colors">
                                Tất cả ({{ $products->total() }})
                            </a>
                            @foreach($categories as $category)
                                <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                   class="block text-sm text-gray-600 hover:text-green-600 transition-colors">
                                    {{ $category->name }} ({{ $category->products_count }})
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Price Range -->
                    <div>
                        <h4 class="font-medium text-gray-900 mb-3">Khoảng giá</h4>
                        <form method="GET" action="{{ route('products.index') }}" class="space-y-3" id="price-filter-form">
                            <input type="hidden" name="category" value="{{ $categoryId }}">
                            <input type="hidden" name="search" value="{{ $query }}">
                            <div class="flex space-x-2">
                                <input type="text" name="min_price_display" id="min_price" placeholder="Từ"
                                       value="{{ request('min_price') ? number_format(request('min_price'), 0, ',', '.') : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                                <input type="text" name="max_price_display" id="max_price" placeholder="Đến"
                                       value="{{ request('max_price') ? number_format(request('max_price'), 0, ',', '.') : '' }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm">
                            </div>
                            <button type="submit"
                                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm transition-colors">
                                Áp dụng
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="lg:w-3/4">
                @if($products->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($products as $product)
                            <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden group cursor-pointer relative">
                                <a href="{{ route('products.show', $product->id) }}" class="block">
                                    <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                        @if($product->image_url)
                                            <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                                                 class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                        @else
                                            <div class="w-full h-48 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                                <i class="fas fa-leaf text-green-400 text-6xl"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="p-4">
                                        <div class="flex items-center justify-between mb-2">
                                            <span class="text-xs text-green-600 bg-green-100 px-2 py-1 rounded-full">{{ $product->category->name }}</span>
                                            @if($product->stock_quantity <= 5)
                                                <span class="text-xs text-orange-600 bg-orange-100 px-2 py-1 rounded-full">Sắp hết</span>
                                            @endif
                                        </div>
                                        <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                            {{ $product->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mb-3">
                                            {{ Str::limit($product->description, 80) }}
                                        </p>
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="text-lg font-bold text-green-600">{{ $product->formatted_price }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- Action buttons overlay -->
                                <div class="absolute bottom-4 right-4 z-10">
                                    <button onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $product->id }})"
                                            class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors shadow-lg">
                                        <i class="fas fa-cart-plus"></i>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8">
                        {{ $products->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                        <h3 class="text-xl font-semibold text-gray-600 mb-2">
                            @if($query)
                                Không tìm thấy sản phẩm nào cho "{{ $query }}"
                            @else
                                Chưa có sản phẩm nào
                            @endif
                        </h3>
                        <p class="text-gray-500 mb-6">
                            @if($query)
                                Thử tìm kiếm với từ khóa khác hoặc xem tất cả sản phẩm
                            @else
                                Vui lòng quay lại sau để xem sản phẩm mới
                            @endif
                        </p>
                        @if($query)
                            <a href="{{ route('products.index') }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg transition-colors">
                                Xem tất cả sản phẩm
                            </a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function addToCart(productId) {
    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: 1
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification('Đã thêm sản phẩm vào giỏ hàng!', 'success');
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }
        } else {
            if (data.redirect) {
                window.location.href = data.redirect;
            } else {
                showNotification(data.message, 'error');
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
    });
}

function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-6 py-3 rounded-lg shadow-lg transition-all duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 'bg-red-500 text-white'
    }`;
    notification.textContent = message;

    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}

// Price formatting functions
function formatNumberInput(input) {
    // Remove all non-numeric characters
    let value = input.value.replace(/[^\d]/g, '');

    // Add thousand separators
    if (value) {
        value = parseInt(value).toLocaleString('vi-VN');
        input.value = value;
    }
}

function parseFormattedNumber(formattedNumber) {
    // Remove thousand separators to get raw number
    return formattedNumber.replace(/\./g, '');
}

// Initialize price formatting
document.addEventListener('DOMContentLoaded', function() {
    const minPriceInput = document.getElementById('min_price');
    const maxPriceInput = document.getElementById('max_price');
    const priceForm = document.getElementById('price-filter-form');

    // Add event listeners for formatting
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

    // Handle form submission - convert formatted numbers back to raw numbers
    if (priceForm) {
        priceForm.addEventListener('submit', function(e) {
            // Create hidden inputs to send raw numbers
            const minPriceHidden = document.createElement('input');
            minPriceHidden.type = 'hidden';
            minPriceHidden.name = 'min_price';
            minPriceHidden.value = minPriceInput && minPriceInput.value ? parseFormattedNumber(minPriceInput.value) : '';

            const maxPriceHidden = document.createElement('input');
            maxPriceHidden.type = 'hidden';
            maxPriceHidden.name = 'max_price';
            maxPriceHidden.value = maxPriceInput && maxPriceInput.value ? parseFormattedNumber(maxPriceInput.value) : '';

            // Add hidden inputs to form
            priceForm.appendChild(minPriceHidden);
            priceForm.appendChild(maxPriceHidden);

            // Keep the visible inputs with formatted values for display
            // Don't modify the visible inputs to avoid flick
        });
    }
});
</script>
@endpush
