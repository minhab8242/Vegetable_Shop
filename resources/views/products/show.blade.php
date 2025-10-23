@extends('layouts.app')

@section('title', $product->name . ' - Vegetable Store')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-6" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-green-600">
                        <i class="fas fa-home mr-2"></i>Trang chủ
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <a href="{{ route('products.index') }}" class="text-gray-700 hover:text-green-600">Sản phẩm</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                        <span class="text-gray-500">{{ $product->name }}</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Product Image -->
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                @if($product->image_url)
                    <img src="{{ asset('storage/' . $product->image_url) }}" alt="{{ $product->name }}"
                         class="w-full h-96 object-cover">
                @else
                    <div class="w-full h-96 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                        <i class="fas fa-leaf text-green-400 text-8xl"></i>
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="mb-4">
                    <span class="text-sm text-green-600 bg-green-100 px-3 py-1 rounded-full">{{ $product->category->name }}</span>
                    <span class="text-sm text-{{ $product->stock_status_color }}-600 bg-{{ $product->stock_status_color }}-100 px-3 py-1 rounded-full ml-2">
                        {{ $product->stock_status }}
                    </span>
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>

                <!-- Rating and Sales -->
                <div class="flex items-center space-x-4 mb-4">
                    <div class="flex items-center space-x-1">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->rating))
                                <i class="fas fa-star text-yellow-400"></i>
                            @elseif($i - 0.5 <= $product->rating)
                                <i class="fas fa-star-half-alt text-yellow-400"></i>
                            @else
                                <i class="far fa-star text-gray-300"></i>
                            @endif
                        @endfor
                        <span class="text-sm text-gray-600 ml-1">{{ number_format($product->rating, 1) }} ({{ $product->review_count ?? 0 }} đánh giá)</span>
                    </div>
                    <div class="text-sm text-gray-500">
                        <i class="fas fa-chart-line mr-1"></i>
                        Đã bán {{ $product->sales_count ?? 0 }}
                    </div>
                </div>

                <div class="mb-6">
                    <span class="text-3xl font-bold text-green-600">{{ $product->formatted_price }}</span>
                </div>

                @if($product->description)
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Mô tả sản phẩm</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>
                @endif

                <!-- Product Details -->
                <div class="mb-6">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-box text-gray-400"></i>
                            <span class="text-gray-600">
                                @if($product->stock_quantity > 0)
                                    Còn {{ $product->stock_quantity }} sản phẩm
                                @else
                                    <span class="text-red-600">Hết hàng</span>
                                @endif
                            </span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-weight text-gray-400"></i>
                            <span class="text-gray-600">500g</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-calendar text-gray-400"></i>
                            <span class="text-gray-600">Hạn sử dụng: 3-5 ngày</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shipping-fast text-gray-400"></i>
                            <span class="text-gray-600">Giao hàng trong 2h</span>
                        </div>
                    </div>
                </div>

                <!-- Add to Cart -->
                @if($product->stock_quantity > 0)
                    @auth
                        <div class="mb-6">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center border border-gray-300 rounded-lg">
                                    <button onclick="updateQuantity(-1)"
                                            class="px-3 py-2 text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    <input type="number" id="quantity" value="1" min="1" max="{{ $product->stock_quantity }}"
                                           class="w-16 text-center border-0 focus:ring-0">
                                    <button onclick="updateQuantity(1)"
                                            class="px-3 py-2 text-gray-600 hover:text-gray-800">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <button onclick="addToCart({{ $product->id }})"
                                        class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                                    <i class="fas fa-cart-plus mr-2"></i>
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="mb-6">
                            <a href="{{ route('login') }}"
                               class="w-full bg-gray-400 hover:bg-gray-500 text-white px-6 py-3 rounded-lg font-semibold transition-colors text-center block">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Đăng nhập để mua hàng
                            </a>
                        </div>
                    @endauth
                @else
                    <div class="mb-6">
                        <button disabled
                                class="w-full bg-gray-300 text-gray-500 px-6 py-3 rounded-lg font-semibold cursor-not-allowed">
                            <i class="fas fa-times mr-2"></i>
                            Sản phẩm hết hàng
                        </button>
                    </div>
                @endif

                <!-- Product Features -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Đặc điểm sản phẩm</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-leaf text-green-600"></i>
                            <span class="text-sm text-gray-600">Tươi ngon</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-shield-alt text-green-600"></i>
                            <span class="text-sm text-gray-600">An toàn</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-truck text-green-600"></i>
                            <span class="text-sm text-gray-600">Giao hàng nhanh</span>
                        </div>
                        <div class="flex items-center space-x-2">
                            <i class="fas fa-undo text-green-600"></i>
                            <span class="text-sm text-gray-600">Đổi trả dễ dàng</span>
                        </div>
                    </div>
                </div>

                <!-- Nutritional Info -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin dinh dưỡng</h3>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Calories:</span>
                            <span class="font-medium">25 kcal</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Protein:</span>
                            <span class="font-medium">2.5g</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Carbs:</span>
                            <span class="font-medium">5g</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fiber:</span>
                            <span class="font-medium">2g</span>
                        </div>
                    </div>
                </div>

                <!-- Storage Instructions -->
                <div class="border-t pt-6 mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Hướng dẫn bảo quản</h3>
                    <div class="space-y-2 text-sm text-gray-600">
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-snowflake text-blue-500 mt-1"></i>
                            <span>Bảo quản trong tủ lạnh ở nhiệt độ 2-4°C</span>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-seedling text-green-500 mt-1"></i>
                            <span>Giữ nguyên bao bì để giữ độ tươi</span>
                        </div>
                        <div class="flex items-start space-x-2">
                            <i class="fas fa-clock text-orange-500 mt-1"></i>
                            <span>Sử dụng trong vòng 3-5 ngày sau khi mua</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-16">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Đánh giá sản phẩm</h2>

                <!-- Rating Summary -->
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                    <!-- Overall Rating -->
                    <div class="text-center">
                        <div class="text-4xl font-bold text-green-600 mb-2">{{ number_format($product->rating, 1) }}</div>
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->rating))
                                    <i class="fas fa-star text-yellow-400"></i>
                                @elseif($i - 0.5 <= $product->rating)
                                    <i class="fas fa-star-half-alt text-yellow-400"></i>
                                @else
                                    <i class="far fa-star text-gray-300"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-gray-600">Dựa trên {{ $product->review_count ?? 0 }} đánh giá</p>
                    </div>

                    <!-- Rating Distribution -->
                    <div class="lg:col-span-2">
                        @php
                            $ratingDistribution = $product->getRatingDistribution();
                            $totalReviews = $product->getTotalReviews();
                        @endphp

                        @for($rating = 5; $rating >= 1; $rating--)
                            <div class="flex items-center mb-2">
                                <span class="text-sm text-gray-600 w-8">{{ $rating }} sao</span>
                                <div class="flex-1 mx-3 bg-gray-200 rounded-full h-2">
                                    <div class="bg-yellow-400 h-2 rounded-full"
                                         style="width: {{ $totalReviews > 0 ? (($ratingDistribution[$rating] ?? 0) / $totalReviews) * 100 : 0 }}%"></div>
                                </div>
                                <span class="text-sm text-gray-600 w-8">{{ $ratingDistribution[$rating] ?? 0 }}</span>
                            </div>
                        @endfor
                    </div>
                </div>

                <!-- Recent Reviews -->
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Đánh giá gần đây</h3>

                    @php
                        $recentReviews = $product->getRecentReviews(5);
                    @endphp

                    @if($recentReviews->count() > 0)
                        <div class="space-y-4">
                            @foreach($recentReviews as $review)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-start justify-between mb-2">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                                <i class="fas fa-user text-green-600 text-sm"></i>
                                            </div>
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $review->user->full_name }}</p>
                                                <div class="flex items-center space-x-1">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= $review->rating)
                                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                        @else
                                                            <i class="far fa-star text-gray-300 text-xs"></i>
                                                        @endif
                                                    @endfor
                                                    <span class="text-xs text-gray-500 ml-1">{{ $review->formatted_date }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        @if($review->is_verified_purchase)
                                            <span class="text-xs bg-green-100 text-green-600 px-2 py-1 rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>Đã mua
                                            </span>
                                        @endif
                                    </div>

                                    @if($review->title)
                                        <h4 class="font-medium text-gray-900 mb-1">{{ $review->title }}</h4>
                                    @endif

                                    @if($review->comment)
                                        <p class="text-gray-600 text-sm mb-2">{{ $review->comment }}</p>
                                    @endif

                                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                                        <button class="helpful-btn flex items-center space-x-1 transition-colors {{ $review->is_helpful ? 'text-green-600' : 'text-gray-500 hover:text-green-600' }}" data-review-id="{{ $review->id }}">
                                            <i class="fas fa-thumbs-up"></i>
                                            <span>Hữu ích (<span class="helpful-count">{{ $review->helpful_count }}</span>)</span>
                                        </button>
                                        <span>Trả lời</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        @if(($product->review_count ?? 0) > 5)
                            <div class="text-center mt-6">
                                <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                                    Xem tất cả đánh giá ({{ $product->review_count ?? 0 }})
                                </button>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-8">
                            <i class="fas fa-comments text-gray-400 text-4xl mb-4"></i>
                            <p class="text-gray-600">Chưa có đánh giá nào</p>
                            <p class="text-sm text-gray-500">Hãy là người đầu tiên đánh giá sản phẩm này</p>
                        </div>
                    @endif
                </div>

                <!-- Write Review Form -->
                @auth
                    @php
                        $hasPurchased = Auth::user()->orders()
                            ->whereHas('orderDetails', function ($query) use ($product) {
                                $query->where('product_id', $product->id);
                            })
                            ->where('status', 'completed')
                            ->exists();

                        $hasReviewed = Auth::user()->reviews()
                            ->where('product_id', $product->id)
                            ->exists();
                    @endphp

                    @if($hasPurchased)
                        @if($hasReviewed)
                            <div class="border-t pt-6 mt-6 text-center">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                                    <i class="fas fa-check-circle text-blue-500 text-3xl mb-3"></i>
                                    <h3 class="text-lg font-semibold text-blue-900 mb-2">Bạn đã đánh giá sản phẩm này</h3>
                                    <p class="text-blue-700">Cảm ơn bạn đã chia sẻ đánh giá về sản phẩm!</p>
                                </div>
                            </div>
                        @else
                            <div class="border-t pt-6 mt-6">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                    <div class="flex items-center">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                        <span class="text-green-700 font-medium">Bạn đã mua sản phẩm này</span>
                                    </div>
                                </div>

                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Viết đánh giá của bạn</h3>

                                <form id="reviewForm" class="space-y-4">
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Đánh giá</label>
                                            <div class="flex items-center space-x-1" id="ratingStars">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="far fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors"
                                                       data-rating="{{ $i }}"></i>
                                                @endfor
                                            </div>
                                            <input type="hidden" name="rating" id="rating" value="0">
                                        </div>

                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Tiêu đề</label>
                                            <input type="text" name="title"
                                                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                   placeholder="Tiêu đề đánh giá">
                                        </div>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Bình luận</label>
                                        <textarea name="comment" rows="4"
                                                  class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                                  placeholder="Chia sẻ trải nghiệm của bạn về sản phẩm này..."></textarea>
                                    </div>

                                    <div class="flex justify-end">
                                        <button type="submit"
                                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                                            Gửi đánh giá
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    @else
                        <div class="border-t pt-6 mt-6 text-center">
                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                                <i class="fas fa-shopping-cart text-gray-400 text-3xl mb-3"></i>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Mua sản phẩm để đánh giá</h3>
                                <p class="text-gray-600 mb-4">Chỉ những khách hàng đã mua sản phẩm mới có thể viết đánh giá</p>
                                @if($product->stock_quantity > 0)
                                    <button onclick="addToCart({{ $product->id }})"
                                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                                        <i class="fas fa-cart-plus mr-2"></i>
                                        Thêm vào giỏ hàng
                                    </button>
                                @else
                                    <p class="text-red-600 font-medium">Sản phẩm hiện đang hết hàng</p>
                                @endif
                            </div>
                        </div>
                    @endif
                @else
                    <div class="border-t pt-6 mt-6 text-center">
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-6">
                            <i class="fas fa-user text-gray-400 text-3xl mb-3"></i>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Đăng nhập để đánh giá</h3>
                            <p class="text-gray-600 mb-4">Vui lòng đăng nhập để có thể đánh giá sản phẩm</p>
                            <a href="{{ route('login') }}"
                               class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
                                Đăng nhập
                            </a>
                        </div>
                    </div>
                @endauth
            </div>
        </div>

        <!-- Related Products -->
        @if($relatedProducts->count() > 0)
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-gray-900 mb-8">Sản phẩm liên quan</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $relatedProduct)
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-lg transition-shadow duration-300 overflow-hidden group cursor-pointer relative">
                            <a href="{{ route('products.show', $relatedProduct->id) }}" class="block">
                                <div class="aspect-w-1 aspect-h-1 bg-gray-200">
                                    @if($relatedProduct->image_url)
                                        <img src="{{ asset('storage/' . $relatedProduct->image_url) }}" alt="{{ $relatedProduct->name }}"
                                             class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <div class="w-full h-48 bg-gradient-to-br from-green-100 to-green-200 flex items-center justify-center">
                                            <i class="fas fa-leaf text-green-400 text-6xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="font-semibold text-gray-900 mb-2 group-hover:text-green-600 transition-colors">
                                        {{ $relatedProduct->name }}
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-3">
                                        {{ Str::limit($relatedProduct->description, 50) }}
                                    </p>
                                    <div class="flex items-center justify-between">
                                        <span class="text-lg font-bold text-green-600">{{ $relatedProduct->formatted_price }}</span>
                                    </div>
                                </div>
                            </a>

                            <!-- Action buttons overlay -->
                            <div class="absolute bottom-4 right-4 z-10 flex space-x-2">
                                <button onclick="event.preventDefault(); event.stopPropagation(); addToCart({{ $relatedProduct->id }})"
                                        class="bg-green-600 hover:bg-green-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors shadow-lg">
                                    <i class="fas fa-cart-plus"></i>
                                </button>
                                <a href="{{ route('products.show', $relatedProduct->id) }}"
                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-sm font-medium transition-colors shadow-lg inline-block"
                                   onclick="event.stopPropagation();">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateQuantity(change) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = currentValue + change;
    const maxValue = parseInt(quantityInput.getAttribute('max'));

    if (newValue >= 1 && newValue <= maxValue) {
        quantityInput.value = newValue;
    }
}

function addToCart(productId) {
    const quantity = document.getElementById('quantity').value;

    fetch('{{ route("cart.add") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            product_id: productId,
            quantity: parseInt(quantity)
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
                // Redirect to login page for unauthenticated users
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

// Rating stars functionality
document.addEventListener('DOMContentLoaded', function() {
    const ratingStarsEl = document.getElementById('ratingStars');
    const stars = document.querySelectorAll('#ratingStars i');
    const ratingInput = document.getElementById('rating');
    let currentRating = 0;

    if (ratingStarsEl && ratingInput && stars.length > 0) {
        stars.forEach((star, index) => {
            star.addEventListener('click', function() {
                currentRating = index + 1;
                ratingInput.value = currentRating;
                updateStars();
            });

            star.addEventListener('mouseenter', function() {
                highlightStars(index + 1);
            });
        });

        ratingStarsEl.addEventListener('mouseleave', function() {
            updateStars();
        });

        function updateStars() {
            stars.forEach((star, index) => {
                if (index < currentRating) {
                    star.className = 'fas fa-star text-2xl text-yellow-400 cursor-pointer transition-colors';
                } else {
                    star.className = 'far fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors';
                }
            });
        }

        function highlightStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.className = 'fas fa-star text-2xl text-yellow-400 cursor-pointer transition-colors';
                } else {
                    star.className = 'far fa-star text-2xl text-gray-300 cursor-pointer hover:text-yellow-400 transition-colors';
                }
            });
        }
    }

    // Review form submission
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (currentRating === 0) {
                showNotification('Vui lòng chọn đánh giá', 'error');
                return;
            }

            const formData = new FormData(this);
            formData.append('rating', currentRating);

            fetch(`/products/{{ $product->id }}/reviews`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showNotification('Đánh giá đã được thêm thành công!', 'success');
                    location.reload(); // Reload to show new review
                } else {
                    showNotification(data.message, 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
            });
        });
    }

    // Helpful button handlers
    document.querySelectorAll('.helpful-btn').forEach(btn => {
        btn.addEventListener('click', function(e){
            e.preventDefault();
            const reviewId = this.getAttribute('data-review-id');
            fetch(`/reviews/${reviewId}/helpful`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(async res => {
                const ct = res.headers.get('content-type')||'';
                const data = ct.includes('application/json') ? await res.json() : {success:false,message:'Lỗi không xác định'};
                if (res.status === 401) {
                    showNotification('Bạn cần đăng nhập để thực hiện hành động này', 'error');
                    return;
                }
                if (data.success) {
                    const countEl = this.querySelector('.helpful-count');
                    if (countEl) countEl.textContent = data.helpful_count;
                    // Toggle highlight
                    if (data.is_helpful) {
                        this.classList.add('text-green-600');
                        this.classList.remove('text-gray-500');
                    } else {
                        this.classList.remove('text-green-600');
                        this.classList.add('text-gray-500');
                    }
                    showNotification(data.message || 'Cập nhật thành công', 'success');
                } else {
                    showNotification(data.message || 'Có lỗi xảy ra', 'error');
                }
            })
            .catch(()=> showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error'));
        });
    });
});
</script>
@endpush
