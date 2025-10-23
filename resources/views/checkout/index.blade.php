@extends('layouts.app')

@section('title', 'Thanh toán - Vegetable Store')

@section('content')
<div class="bg-gray-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Thanh toán</h1>
            <p class="text-gray-600 mt-2">Hoàn tất đơn hàng của bạn</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Order Summary -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl shadow-sm">
                    <div class="p-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900">Đơn hàng của bạn</h2>
                    </div>

                    <div class="divide-y divide-gray-200">
                        @foreach($checkoutItems as $item)
                            <div class="p-6">
                                <div class="flex items-center space-x-4">
                                    <!-- Product Image -->
                                    <div class="flex-shrink-0">
                                        @if($item['product']['image_url'] ?? false)
                                            <img src="{{ $item['product']['image_url'] }}" alt="{{ $item['product']['name'] }}"
                                                 class="w-16 h-16 object-cover rounded-lg">
                                        @else
                                            <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center">
                                                <i class="fas fa-leaf text-green-400 text-xl"></i>
                                            </div>
                                        @endif
                                    </div>

                                    <!-- Product Info -->
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $item['product']['name'] }}
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $item['product']['category']['name'] ?? 'N/A' }}</p>
                                        <p class="text-sm text-gray-500">{{ number_format($item['price'], 0, ',', '.') }} VND</p>
                                    </div>

                                    <!-- Quantity -->
                                    <div class="text-right">
                                        <div class="text-lg font-semibold text-gray-900">
                                            Số lượng: {{ $item['quantity'] }}
                                        </div>
                                        <div class="text-lg font-semibold text-green-600">
                                            {{ number_format($item['subtotal'], 0, ',', '.') }} VND
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Payment Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-6 sticky top-8">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Tóm tắt thanh toán</h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tạm tính:</span>
                            <span class="font-semibold">{{ number_format($checkoutTotal, 0, ',', '.') }} VND</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Phí vận chuyển:</span>
                            <span class="font-semibold text-green-600">Miễn phí</span>
                        </div>
                        <div class="border-t pt-3">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Tổng cộng:</span>
                                <span class="text-green-600">{{ number_format($checkoutTotal, 0, ',', '.') }} VND</span>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <button onclick="processPayment()" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-credit-card mr-2"></i>
                            Thanh toán ngay
                        </button>

                        <a href="{{ route('cart.index') }}" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-lg font-semibold transition-colors text-center block">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Quay lại giỏ hàng
                        </a>
                    </div>

                    <div class="mt-4 text-center">
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-shield-alt mr-1"></i>
                            Thanh toán an toàn và bảo mật
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function processPayment() {
    const button = event.target;
    const originalText = button.innerHTML;
    button.disabled = true;
    button.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...';

    setTimeout(() => {
        showNotification('Thanh toán thành công! Đơn hàng đã được tạo.', 'success');

        fetch('/cart/clear', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });

        setTimeout(() => {
            window.location.href = '/';
        }, 2000);
    }, 2000);
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
</script>
@endpush

