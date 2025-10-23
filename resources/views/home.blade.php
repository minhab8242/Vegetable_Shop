@extends('layouts.app')

@section('title', 'Vegetable Store - Rau Củ Quả Tươi Ngon')
@section('description', 'Cửa hàng rau củ quả tươi ngon, chất lượng cao. Giao hàng tận nơi, giá cả hợp lý.')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-r from-green-600 to-green-800 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="space-y-6">
                <h1 class="text-4xl lg:text-6xl font-bold leading-tight">
                    Rau Củ Quả
                    <span class="text-yellow-300">Tươi Ngon</span>
                </h1>
                <p class="text-xl text-green-100">
                    Cung cấp rau củ quả tươi ngon, chất lượng cao với giá cả hợp lý.
                    Giao hàng tận nơi, đảm bảo sức khỏe cho gia đình bạn.
                </p>
                <div class="flex items-center space-x-8 text-green-100">
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Giao hàng miễn phí</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-6 h-6 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Chất lượng đảm bảo</span>
                    </div>
                </div>
            </div>
            <div class="relative">
                <!-- Image Slider -->
                <div class="relative overflow-hidden rounded-2xl shadow-2xl">
                    <div class="flex transition-transform duration-500 ease-in-out" id="imageSlider">
                        <!-- Slide 1: Fresh Vegetables -->
                        <div class="w-full flex-shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1540420773420-3366772f4999?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                                 alt="Fresh Vegetables"
                                 class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <h3 class="text-2xl font-bold mb-2">Rau Xanh Tươi</h3>
                                <p class="text-green-200">100% tự nhiên, không hóa chất</p>
                            </div>
                        </div>

                        <!-- Slide 2: Fresh Fruits -->
                        <div class="w-full flex-shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1610832958506-aa563b7041ba?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                                 alt="Fresh Fruits"
                                 class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <h3 class="text-2xl font-bold mb-2">Trái Cây Tươi</h3>
                                <p class="text-green-200">Ngọt ngào, giàu vitamin</p>
                            </div>
                        </div>

                        <!-- Slide 3: Organic Vegetables -->
                        <div class="w-full flex-shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1578662996442-48f60103fc96?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                                 alt="Organic Vegetables"
                                 class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <h3 class="text-2xl font-bold mb-2">Rau Hữu Cơ</h3>
                                <p class="text-green-200">An toàn cho sức khỏe</p>
                            </div>
                        </div>

                        <!-- Slide 4: Fresh Herbs -->
                        <div class="w-full flex-shrink-0 relative">
                            <img src="https://images.unsplash.com/photo-1586201375761-83865001e31c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                                 alt="Fresh Herbs"
                                 class="w-full h-96 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                            <div class="absolute bottom-6 left-6 text-white">
                                <h3 class="text-2xl font-bold mb-2">Gia Vị Tươi</h3>
                                <p class="text-green-200">Thơm ngon, đậm đà</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Dots -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
                        <button onclick="currentSlide(1)" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors slider-dot active"></button>
                        <button onclick="currentSlide(2)" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors slider-dot"></button>
                        <button onclick="currentSlide(3)" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors slider-dot"></button>
                        <button onclick="currentSlide(4)" class="w-3 h-3 rounded-full bg-white/50 hover:bg-white transition-colors slider-dot"></button>
                    </div>

                    <!-- Navigation Arrows -->
                    <button onclick="changeSlide(-1)" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button onclick="changeSlide(1)" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/20 hover:bg-white/30 text-white p-2 rounded-full transition-colors">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Tại sao chọn chúng tôi?</h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Chúng tôi cam kết mang đến cho bạn những sản phẩm chất lượng nhất với dịch vụ tốt nhất
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center group">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-shipping-fast text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Giao hàng nhanh</h3>
                <p class="text-gray-600">Giao hàng trong vòng 2-4 giờ, đảm bảo sản phẩm tươi ngon</p>
            </div>

            <div class="text-center group">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-check-circle text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Chất lượng đảm bảo</h3>
                <p class="text-gray-600">Sản phẩm được kiểm tra kỹ lưỡng trước khi giao đến tay khách hàng</p>
            </div>

            <div class="text-center group">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-dollar-sign text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Giá cả hợp lý</h3>
                <p class="text-gray-600">Giá cả cạnh tranh, không qua trung gian, tiết kiệm chi phí</p>
            </div>

            <div class="text-center group">
                <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                    <i class="fas fa-headset text-green-600 text-2xl"></i>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">Hỗ trợ 24/7</h3>
                <p class="text-gray-600">Đội ngũ hỗ trợ khách hàng luôn sẵn sàng giúp đỡ bạn</p>
            </div>
        </div>
    </div>
</section>
<!-- Categories Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Danh mục sản phẩm</h2>
            <p class="text-lg text-gray-600">Khám phá đa dạng các loại rau củ quả</p>
        </div>

        @if($categories->count() > 0)
            <div class="relative">
                <!-- Navigation arrows -->
                <button id="categoriesPrev" class="absolute left-0 top-1/2 transform -translate-y-1/2 -translate-x-4 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50 transition-colors z-10">
                    <i class="fas fa-chevron-left text-gray-600"></i>
                </button>
                <button id="categoriesNext" class="absolute right-0 top-1/2 transform -translate-y-1/2 translate-x-4 bg-white shadow-lg rounded-full p-2 hover:bg-gray-50 transition-colors z-10">
                    <i class="fas fa-chevron-right text-gray-600"></i>
                </button>

                <!-- Categories carousel -->
                <div class="overflow-hidden">
                    <div id="categoriesCarousel" class="flex transition-transform duration-300 ease-in-out">
                        @foreach($categories as $category)
                            <div class="flex-shrink-0 w-1/2 md:w-1/3 lg:w-1/5 px-3">
                                <a href="{{ route('products.index', ['category' => $category->id]) }}" class="group block">
                                    <div class="bg-gray-50 hover:bg-green-50 rounded-xl p-6 text-center transition-colors">
                                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4 group-hover:bg-green-200 transition-colors">
                                            <i class="fas fa-leaf text-green-600 text-2xl"></i>
                                        </div>
                                        <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition-colors">
                                            {{ $category->name }}
                                        </h3>
                                        <p class="text-sm text-gray-600 mt-1">{{ $category->products_count }} sản phẩm</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Dots indicator -->
                <div id="categoriesDots" class="flex justify-center mt-6 space-x-2">
                    <!-- Dots will be generated by JavaScript -->
                </div>
            </div>
        @else
            <div class="text-center py-12">
                <i class="fas fa-tags text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có danh mục nào</h3>
                <p class="text-gray-500">Vui lòng quay lại sau để xem danh mục sản phẩm</p>
            </div>
        @endif
    </div>
</section>
<!-- Featured Products Section -->
<section class="py-16 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <h2 class="text-3xl font-bold text-gray-900 mb-4">Sản phẩm nổi bật</h2>
            <p class="text-lg text-gray-600">Những sản phẩm được yêu thích nhất</p>
        </div>

        @if($featuredProducts->count() > 0)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredProducts as $product)
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
                                    {{ Str::limit($product->description, 50) }}
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
        @else
            <div class="text-center py-12">
                <i class="fas fa-box-open text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-semibold text-gray-600 mb-2">Chưa có sản phẩm nào</h3>
                <p class="text-gray-500">Vui lòng quay lại sau để xem sản phẩm mới</p>
            </div>
        @endif

        <div class="text-center mt-12">
            <a href="{{ route('products.index') }}"
               class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                Xem tất cả sản phẩm
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    </div>
</section>



@endsection

@push('scripts')
<script>
let currentSlideIndex = 0;
const totalSlides = 4;
let slideInterval;

document.addEventListener('DOMContentLoaded', function() {
    startAutoSlide();
});

function startAutoSlide() {
    slideInterval = setInterval(() => {
        currentSlideIndex = (currentSlideIndex + 1) % totalSlides;
        updateSlider();
    }, 4000);
}

function stopAutoSlide() {
    clearInterval(slideInterval);
}

function changeSlide(direction) {
    stopAutoSlide();
    currentSlideIndex = (currentSlideIndex + direction + totalSlides) % totalSlides;
    updateSlider();
    startAutoSlide();
}

function currentSlide(slideNumber) {
    stopAutoSlide();
    currentSlideIndex = slideNumber - 1;
    updateSlider();
    startAutoSlide();
}

function updateSlider() {
    const slider = document.getElementById('imageSlider');
    const dots = document.querySelectorAll('.slider-dot');

    slider.style.transform = `translateX(-${currentSlideIndex * 100}%)`;

    dots.forEach((dot, index) => {
        dot.classList.toggle('active', index === currentSlideIndex);
        dot.classList.toggle('bg-white', index === currentSlideIndex);
        dot.classList.toggle('bg-white/50', index !== currentSlideIndex);
    });
}

document.getElementById('imageSlider').addEventListener('mouseenter', stopAutoSlide);
document.getElementById('imageSlider').addEventListener('mouseleave', startAutoSlide);

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

document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('categoriesCarousel');
    const prevBtn = document.getElementById('categoriesPrev');
    const nextBtn = document.getElementById('categoriesNext');
    const dotsContainer = document.getElementById('categoriesDots');

    if (!carousel || !prevBtn || !nextBtn) return;

    const categories = carousel.children;
    const totalCategories = categories.length;

    if (totalCategories <= 5) {
        prevBtn.style.display = 'none';
        nextBtn.style.display = 'none';
        dotsContainer.style.display = 'none';
        return;
    }

    let currentIndex = 0;
    const itemsPerView = 5;
    const totalSlides = Math.ceil(totalCategories / itemsPerView);

    for (let i = 0; i < totalSlides; i++) {
        const dot = document.createElement('button');
        dot.className = `w-2 h-2 rounded-full transition-colors ${i === 0 ? 'bg-green-600' : 'bg-gray-300'}`;
        dot.addEventListener('click', () => goToSlide(i));
        dotsContainer.appendChild(dot);
    }

    function updateCarousel() {
        const translateX = -currentIndex * (100 / itemsPerView);
        carousel.style.transform = `translateX(${translateX}%)`;

        const dots = dotsContainer.children;
        for (let i = 0; i < dots.length; i++) {
            dots[i].className = `w-2 h-2 rounded-full transition-colors ${i === currentIndex ? 'bg-green-600' : 'bg-gray-300'}`;
        }
    }

    function goToSlide(index) {
        currentIndex = index;
        updateCarousel();
    }

    function nextSlide() {
        currentIndex = (currentIndex + 1) % totalSlides;
        updateCarousel();
    }

    function prevSlide() {
        currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
        updateCarousel();
    }

    nextBtn.addEventListener('click', nextSlide);
    prevBtn.addEventListener('click', prevSlide);

    let autoPlayInterval;

    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 4000);
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    startAutoPlay();

    carousel.addEventListener('mouseenter', stopAutoPlay);
    carousel.addEventListener('mouseleave', startAutoPlay);

    let startX = 0;
    let isDragging = false;

    carousel.addEventListener('touchstart', (e) => {
        startX = e.touches[0].clientX;
        isDragging = true;
        stopAutoPlay();
    });

    carousel.addEventListener('touchmove', (e) => {
        if (!isDragging) return;
        e.preventDefault();
    });

    carousel.addEventListener('touchend', (e) => {
        if (!isDragging) return;

        const endX = e.changedTouches[0].clientX;
        const diffX = startX - endX;

        if (Math.abs(diffX) > 50) {
            if (diffX > 0) {
                nextSlide();
            } else {
                prevSlide();
            }
        }

        isDragging = false;
        startAutoPlay();
    });
});
</script>
@endpush
