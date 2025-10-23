@extends('layouts.app')

@section('title', 'Giỏ hàng - Vegetable Store')

@section('content')
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if($cartItems->count() > 0)
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Cart Items -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-xl shadow-sm">
                        <div class="p-6 border-b border-gray-200">
                            <div class="flex items-center justify-between">
                                <h2 class="text-lg font-semibold text-gray-900">Sản phẩm trong giỏ ({{ $cartItems->count() }} món)</h2>
                                <div class="flex items-center space-x-2">
                                    <input type="checkbox" id="select-all" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                                    <label for="select-all" class="text-sm text-gray-700">Chọn tất cả</label>
                                </div>
                            </div>
                        </div>

                        <div id="cart-items-scroll" class="divide-y divide-gray-200 max-h-[50vh] min-h-[300px] overflow-y-scroll pr-2">
                            @foreach($cartItems as $item)
                                <div class="p-6 cart-item {{ $loop->index >= 5 ? 'hidden' : '' }}" id="cart-item-{{ $item->id }}" data-index="{{ $loop->index }}">
                                    <div class="flex items-center space-x-4">
                                        <!-- Checkbox -->
                                        <input type="checkbox"
                                               class="item-checkbox h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                               value="{{ $item->id }}"
                                               data-price="{{ $item->subtotal }}"
                                               onchange="updateSelectedItems()">

                                        <!-- Product Image -->
                                        <div class="flex-shrink-0">
                                            @if($item->product->image_url)
                                                <img src="{{ asset('storage/' . $item->product->image_url) }}" alt="{{ $item->product->name }}"
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
                                                <a href="{{ route('products.show', $item->product->id) }}"
                                                   class="hover:text-green-600 transition-colors">
                                                    {{ $item->product->name }}
                                                </a>
                                            </h3>
                                            <p class="text-sm text-gray-600">{{ $item->product->category->name }}</p>
                                            <p class="text-sm text-gray-500">{{ $item->product->formatted_price }}</p>
                                        </div>

                                        <!-- Quantity Controls -->
                                        <div class="flex items-center space-x-2">
                                            <button onclick="updateCartItem({{ $item->id }}, {{ $item->quantity - 1 }})"
                                                    class="decrease-btn w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                                    {{ $item->quantity <= 1 ? 'disabled' : '' }}>
                                                <i class="fas fa-minus text-gray-600"></i>
                                            </button>
                                            <span class="quantity-display w-12 text-center font-medium">{{ $item->quantity }}</span>
                                            <button onclick="updateCartItem({{ $item->id }}, {{ $item->quantity + 1 }})"
                                                    class="increase-btn w-8 h-8 rounded-full border border-gray-300 flex items-center justify-center hover:bg-gray-50">
                                                <i class="fas fa-plus text-gray-600"></i>
                                            </button>
                                        </div>

                                        <!-- Price -->
                                        <div class="text-right">
                                            <div class="subtotal-display text-lg font-semibold text-gray-900">
                                                {{ number_format($item->subtotal, 0, ',', '.') }} VND
                                            </div>
                                        </div>

                                        <!-- Remove Button -->
                                        <button onclick="removeCartItem({{ $item->id }})"
                                                class="text-red-600 hover:text-red-800 transition-colors">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                            <!-- Virtual spacer for lazy scroll -->
                            <div id="cart-virtual-spacer"></div>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('products.index') }}"
                           class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Tiếp tục mua sắm
                        </a>
                        <button onclick="clearCart()"
                                class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                            <i class="fas fa-trash mr-2"></i>
                            Xóa tất cả
                        </button>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tóm tắt đơn hàng</h3>

                        <div class="space-y-3 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tạm tính:</span>
                                <span class="font-semibold" id="selected-subtotal">{{ number_format($cartTotal, 0, ',', '.') }} VND</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Phí vận chuyển:</span>
                                <span class="font-semibold text-green-600">Miễn phí</span>
                            </div>
                            <div class="border-t pt-3">
                                <div class="flex justify-between text-lg font-bold">
                                    <span>Tổng cộng:</span>
                                    <span class="text-green-600" id="selected-total">{{ number_format($cartTotal, 0, ',', '.') }} VND</span>
                                </div>
                            </div>
                        </div>

                        <button id="checkout-btn" onclick="checkout()" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <i class="fas fa-credit-card mr-2"></i>
                            <span id="checkout-text">Chọn sản phẩm để thanh toán</span>
                        </button>

                        <div class="mt-4 text-center">
                            <p class="text-sm text-gray-600">
                                <i class="fas fa-shield-alt mr-1"></i>
                                Thanh toán an toàn và bảo mật
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <!-- Empty Cart -->
            <div class="text-center py-16">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-shopping-cart text-gray-400 text-4xl"></i>
                </div>
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Giỏ hàng trống</h2>
                <p class="text-gray-600 mb-8">Bạn chưa có sản phẩm nào trong giỏ hàng</p>
                <a href="{{ route('products.index') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-8 py-3 rounded-lg font-semibold transition-colors inline-flex items-center">
                    <i class="fas fa-shopping-bag mr-2"></i>
                    Bắt đầu mua sắm
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Checkout Confirmation Modal -->
<div id="checkout-modal" class="fixed inset-0 backdrop-blur-sm z-50 hidden">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-900">Xác nhận thanh toán</h3>
                <button onclick="closeCheckoutModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <!-- User Information Section -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Thông tin cá nhân
                    </h4>

                    <div id="user-info-display" class="space-y-3">
                        <!-- User info will be populated here -->
                    </div>

                    <!-- Inline Edit Form -->
                    <div id="user-info-edit" class="hidden space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-user text-gray-400 mr-2"></i>
                                    Họ tên <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="edit-name"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Nhập họ và tên">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-phone text-gray-400 mr-2"></i>
                                    Số điện thoại
                                </label>
                                <input type="tel" id="edit-phone"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                       placeholder="Nhập số điện thoại">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    <i class="fas fa-map-marker-alt text-gray-400 mr-2"></i>
                                    Địa chỉ
                                </label>
                                <textarea id="edit-address" rows="2"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                          placeholder="Nhập địa chỉ"></textarea>
                            </div>
                        </div>

                        <div class="flex gap-3">
                            <button onclick="saveUserInfo(this)"
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Lưu thông tin
                            </button>
                            <button onclick="cancelEditUserInfo()"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium transition-colors">
                                <i class="fas fa-times mr-2"></i>
                                Hủy
                            </button>
                        </div>
                    </div>

                    <div id="missing-info-alert" class="hidden bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-2"></i>
                            <span class="text-yellow-800 font-medium">Thông tin còn thiếu</span>
                        </div>
                        <p class="text-yellow-700 text-sm mt-1">Vui lòng cập nhật thông tin cá nhân để tiếp tục thanh toán</p>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="mb-6">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-shopping-cart mr-2 text-green-600"></i>
                        Tóm tắt đơn hàng
                    </h4>

                    <div id="checkout-items-scroll" class="space-y-2 max-h-[30vh] min-h-[160px] overflow-y-auto pr-1">
                        <div id="checkout-items"></div>
                        <div id="checkout-virtual-spacer"></div>
                    </div>

                    <div class="border-t pt-3 mt-4">
                        <div class="flex justify-between text-lg font-bold">
                            <span>Tổng cộng:</span>
                            <span class="text-green-600" id="checkout-total">0 VND</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <button onclick="closeCheckoutModal()"
                            class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Quay lại
                    </button>
                    <button id="update-info-btn" onclick="updateUserInfo()"
                            class="hidden bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-edit mr-2"></i>
                        Cập nhật thông tin
                    </button>
                    <button id="confirm-checkout-btn" onclick="confirmCheckout()"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-credit-card mr-2"></i>
                        Xác nhận thanh toán
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function updateCartItem(cartItemId, quantity) {
    if (quantity < 0) return;

    fetch(`/cart/update/${cartItemId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            quantity: quantity
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            updateCartItemUI(cartItemId, quantity, data.subtotal);
            updateSelectedItems();
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
    });
}

function updateCartItemUI(cartItemId, quantity, subtotal) {
    const cartItem = document.getElementById(`cart-item-${cartItemId}`);
    if (cartItem) {
        const quantitySpan = cartItem.querySelector('.quantity-display');
        if (quantitySpan) {
            quantitySpan.textContent = quantity;
        }

        const subtotalElement = cartItem.querySelector('.subtotal-display');
        if (subtotalElement) {
            subtotalElement.textContent = formatCurrency(subtotal);
        }

        const checkbox = cartItem.querySelector('.item-checkbox');
        if (checkbox) {
            checkbox.dataset.price = subtotal;
        }

        const decreaseBtn = cartItem.querySelector('.decrease-btn');
        const increaseBtn = cartItem.querySelector('.increase-btn');

        if (decreaseBtn) {
            decreaseBtn.disabled = quantity <= 1;
            decreaseBtn.onclick = () => updateCartItem(cartItemId, quantity - 1);
        }

        if (increaseBtn) {
            increaseBtn.onclick = () => updateCartItem(cartItemId, quantity + 1);
        }
    }
}

function removeCartItem(cartItemId) {
    if (!confirm('Bạn có chắc muốn xóa sản phẩm này khỏi giỏ hàng?')) {
        return;
    }

    fetch(`/cart/remove/${cartItemId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`cart-item-${cartItemId}`).remove();
            showNotification('Đã xóa sản phẩm khỏi giỏ hàng', 'success');

            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cart_count;
            }

            if (data.cart_count == 0) {
                location.reload();
            }
        } else {
            showNotification(data.message, 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
    });
}

function clearCart() {
    if (!confirm('Bạn có chắc muốn xóa tất cả sản phẩm khỏi giỏ hàng?')) {
        return;
    }

    fetch('/cart/clear', {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            showNotification(data.message, 'error');
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

function updateSelectedItems() {
    const checkboxes = document.querySelectorAll('.item-checkbox');
    const selectAllCheckbox = document.getElementById('select-all');
    const selectedSubtotal = document.getElementById('selected-subtotal');
    const selectedTotal = document.getElementById('selected-total');
    const checkoutBtn = document.getElementById('checkout-btn');
    const checkoutText = document.getElementById('checkout-text');

    let selectedCount = 0;
    let total = 0;

    checkboxes.forEach(checkbox => {
        if (checkbox.checked) {
            selectedCount++;
            total += parseFloat(checkbox.dataset.price);
        }
    });

    if (selectedCount === 0) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = false;
    } else if (selectedCount === checkboxes.length) {
        selectAllCheckbox.indeterminate = false;
        selectAllCheckbox.checked = true;
    } else {
        selectAllCheckbox.indeterminate = true;
    }

    selectedSubtotal.textContent = formatCurrency(total);
    selectedTotal.textContent = formatCurrency(total);

    if (selectedCount > 0) {
        checkoutBtn.disabled = false;
        checkoutBtn.classList.remove('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
        checkoutBtn.classList.add('bg-green-600', 'hover:bg-green-700');
        checkoutText.textContent = `Thanh toán (${selectedCount} sản phẩm)`;
    } else {
        checkoutBtn.disabled = true;
        checkoutBtn.classList.add('disabled:bg-gray-400', 'disabled:cursor-not-allowed');
        checkoutBtn.classList.remove('bg-green-600', 'hover:bg-green-700');
        checkoutText.textContent = 'Chọn sản phẩm để thanh toán';
    }
}

function selectAllItems() {
    const selectAllCheckbox = document.getElementById('select-all');
    const checkboxes = document.querySelectorAll('.item-checkbox');

    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAllCheckbox.checked;
    });

    updateSelectedItems();
}

function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount) + ' VND';
}

function checkout() {
    const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
        .map(checkbox => checkbox.value);

    if (selectedItems.length === 0) {
        showNotification('Vui lòng chọn ít nhất một sản phẩm để thanh toán', 'error');
        return;
    }

    showCheckoutModal(selectedItems);
}

function showCheckoutModal(selectedItems) {
    fetch('/api/user-info', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            populateUserInfo(data.user);
            populateCheckoutItems(selectedItems);
            checkMissingInfo(data.user);
        } else {
            showNotification('Không thể tải thông tin người dùng', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra khi tải thông tin', 'error');
    });

    document.getElementById('checkout-modal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function populateUserInfo(user) {
    const userInfoDisplay = document.getElementById('user-info-display');

    userInfoDisplay.innerHTML = `
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-user text-gray-400 w-5"></i>
                        <span class="ml-2 text-sm text-gray-600">Họ tên:</span>
                    </div>
                    <button onclick="editUserInfo()" class="text-green-600 hover:text-green-700 text-sm">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div class="ml-7 font-medium ${user.name ? 'text-gray-900' : 'text-red-500'}">
                    ${user.name || 'Chưa cập nhật'}
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex items-center">
                    <i class="fas fa-envelope text-gray-400 w-5"></i>
                    <span class="ml-2 text-sm text-gray-600">Email:</span>
                </div>
                <div class="ml-7 font-medium text-gray-900">
                    ${user.email}
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-phone text-gray-400 w-5"></i>
                        <span class="ml-2 text-sm text-gray-600">Số điện thoại:</span>
                    </div>
                    <button onclick="editUserInfo()" class="text-green-600 hover:text-green-700 text-sm">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div class="ml-7 font-medium ${user.phone ? 'text-gray-900' : 'text-red-500'}">
                    ${user.phone || 'Chưa cập nhật'}
                </div>
            </div>

            <div class="space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <i class="fas fa-map-marker-alt text-gray-400 w-5"></i>
                        <span class="ml-2 text-sm text-gray-600">Địa chỉ:</span>
                    </div>
                    <button onclick="editUserInfo()" class="text-green-600 hover:text-green-700 text-sm">
                        <i class="fas fa-edit"></i>
                    </button>
                </div>
                <div class="ml-7 font-medium ${user.address ? 'text-gray-900' : 'text-red-500'}">
                    ${user.address || 'Chưa cập nhật'}
                </div>
            </div>
        </div>
    `;
}

function populateCheckoutItems(selectedItems) {
    const listContainer = document.getElementById('checkout-items');
    const scrollContainer = document.getElementById('checkout-items-scroll');
    const spacer = document.getElementById('checkout-virtual-spacer');
    const selectedCheckboxes = Array.from(document.querySelectorAll('.item-checkbox:checked'));

    let total = 0;
    const items = [];

    selectedCheckboxes.forEach(checkbox => {
        const cartItemId = checkbox.value;
        const cartItem = document.getElementById(`cart-item-${cartItemId}`);
        if (!cartItem) return;

        const nameLink = cartItem.querySelector('h3 a');
        const productName = nameLink ? nameLink.textContent.trim() : '';
        const quantityText = cartItem.querySelector('.quantity-display')?.textContent || '1';
        const quantity = parseInt(quantityText, 10) || 1;
        const subtotalText = cartItem.querySelector('.subtotal-display')?.textContent || '0';
        const subtotalValue = parseFloat(subtotalText.replace(/[^\d]/g, '')) || 0;

        total += subtotalValue;
        items.push({ productName, quantity, subtotalText });
    });

    document.getElementById('checkout-total').textContent = formatCurrency(total);

    listContainer.innerHTML = '';
    const renderItem = (item, hidden) => {
        const div = document.createElement('div');
        div.className = `flex items-center justify-between py-2 border-b border-gray-100 ${hidden ? 'hidden checkout-item' : 'checkout-item'}`;
        div.innerHTML = `
            <div class="flex-1">
                <div class="font-medium text-gray-900">${item.productName}</div>
                <div class="text-sm text-gray-600">Số lượng: ${item.quantity}</div>
            </div>
            <div class="text-right">
                <div class="font-semibold text-gray-900">${item.subtotalText}</div>
            </div>
        `;
        listContainer.appendChild(div);
        return div;
    };

    const revealBatchSize = 5;
    let revealedCount = 0;
    const elements = items.map((item, idx) => renderItem(item, idx >= revealBatchSize));
    revealedCount = Math.min(revealBatchSize, elements.length);

    const updateSpacer = () => {
        const visible = elements.slice(0, revealedCount);
        let avg = 0;
        if (visible.length > 0) {
            const totalHeight = visible.reduce((sum, el) => sum + el.offsetHeight, 0);
            avg = totalHeight / visible.length;
        }
        const remaining = Math.max(elements.length - revealedCount, 0);
        if (remaining === 0) {
            spacer.style.height = '0px';
            return;
        }
        const fallbackAvg = 56;
        const estimated = remaining * (avg || fallbackAvg) * 0.35;
        const clamped = Math.max(40, Math.min(estimated, 180));
        spacer.style.height = `${Math.round(clamped)}px`;
    };

    const revealMore = () => {
        const hidden = Array.from(listContainer.querySelectorAll('.checkout-item.hidden'));
        if (hidden.length === 0) return;
        hidden.slice(0, revealBatchSize).forEach(el => el.classList.remove('hidden'));
        revealedCount = Math.min(revealedCount + revealBatchSize, elements.length);
        updateSpacer();
    };

    const onScroll = () => {
        if (scrollContainer.scrollTop + scrollContainer.clientHeight >= scrollContainer.scrollHeight - 10) {
            revealMore();
        }
    };

    scrollContainer.removeEventListener('scroll', scrollContainer._checkoutScrollHandler || (()=>{}));
    scrollContainer._checkoutScrollHandler = onScroll;
    scrollContainer.addEventListener('scroll', onScroll);

    setTimeout(updateSpacer, 0);
}

function checkMissingInfo(user) {
    const missingFields = [];

    if (!user.name) missingFields.push('Họ tên');
    if (!user.phone) missingFields.push('Số điện thoại');
    if (!user.address) missingFields.push('Địa chỉ');

    const missingInfoAlert = document.getElementById('missing-info-alert');
    const updateInfoBtn = document.getElementById('update-info-btn');
    const confirmCheckoutBtn = document.getElementById('confirm-checkout-btn');

    if (missingFields.length > 0) {
        missingInfoAlert.classList.remove('hidden');
        updateInfoBtn.classList.remove('hidden');
        confirmCheckoutBtn.disabled = true;
        confirmCheckoutBtn.classList.add('opacity-50', 'cursor-not-allowed');

        const alertText = missingInfoAlert.querySelector('p');
        alertText.textContent = `Thiếu thông tin: ${missingFields.join(', ')}. Vui lòng cập nhật để tiếp tục thanh toán.`;
    } else {
        missingInfoAlert.classList.add('hidden');
        updateInfoBtn.classList.add('hidden');
        confirmCheckoutBtn.disabled = false;
        confirmCheckoutBtn.classList.remove('opacity-50', 'cursor-not-allowed');
    }
}

function closeCheckoutModal() {
    document.getElementById('checkout-modal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function editUserInfo() {
    document.getElementById('user-info-display').classList.add('hidden');
    document.getElementById('user-info-edit').classList.remove('hidden');

    fetch('/api/user-info', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('edit-name').value = data.user.name || '';
            document.getElementById('edit-phone').value = data.user.phone || '';
            document.getElementById('edit-address').value = data.user.address || '';
        }
    });
}

function cancelEditUserInfo() {
    document.getElementById('user-info-edit').classList.add('hidden');
    document.getElementById('user-info-display').classList.remove('hidden');
}

function saveUserInfo(btn) {
    const name = document.getElementById('edit-name').value.trim();
    const phone = document.getElementById('edit-phone').value.trim();
    const address = document.getElementById('edit-address').value.trim();

    if (!name) {
        showNotification('Vui lòng nhập họ tên', 'error');
        return;
    }

    const saveBtn = btn;
    const originalText = saveBtn.innerHTML;
    saveBtn.disabled = true;
    saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';

    fetch('/profile/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            full_name: name,
            phone: phone,
            address: address
        })
    })
    .then(async response => {
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error('Unexpected response: ' + text.slice(0, 120));
        }
        return response.json();
    })
    .then(data => {
        if (data.success || data.message) {
            showNotification('Cập nhật thông tin thành công!', 'success');

            fetch('/api/user-info', { headers: { 'Accept': 'application/json' } })
                .then(r => r.json())
                .then(payload => {
                    if (payload.success) {
                        populateUserInfo(payload.user);
                        checkMissingInfo(payload.user);
                    }
                });

            document.getElementById('user-info-edit').classList.add('hidden');
            document.getElementById('user-info-display').classList.remove('hidden');
        } else {
            showNotification(data.message || 'Có lỗi xảy ra', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
    })
    .finally(() => {
        saveBtn.disabled = false;
        saveBtn.innerHTML = originalText;
    });
}

function updateUserInfo() {
    window.location.href = '/profile/edit';
}

function confirmCheckout() {
    const selectedItems = Array.from(document.querySelectorAll('.item-checkbox:checked'))
        .map(checkbox => checkbox.value);

    if (selectedItems.length === 0) {
        showNotification('Vui lòng chọn ít nhất một sản phẩm để thanh toán', 'error');
        return;
    }

    closeCheckoutModal();

    const checkoutBtn = document.getElementById('checkout-btn');
    const originalText = checkoutBtn.innerHTML;
    checkoutBtn.disabled = true;
    checkoutBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Đang xử lý...';

    fetch('/cart/confirm', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            selected_items: selectedItems
        })
    })
    .then(async response => {
        const contentType = response.headers.get('content-type') || '';
        if (!contentType.includes('application/json')) {
            const text = await response.text();
            throw new Error('Unexpected response: ' + text.slice(0, 120));
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            showNotification(data.message, 'success');
            setTimeout(() => {
                window.location.href = '/orders';
            }, 1200);
        } else {
            showNotification(data.message, 'error');
            checkoutBtn.disabled = false;
            checkoutBtn.innerHTML = originalText;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('Có lỗi xảy ra, vui lòng thử lại', 'error');
        checkoutBtn.disabled = false;
        checkoutBtn.innerHTML = originalText;
    });
}

document.addEventListener('DOMContentLoaded', function() {
    const selectAllCheckbox = document.getElementById('select-all');
    if (selectAllCheckbox) {
        selectAllCheckbox.addEventListener('change', selectAllItems);
    }

    updateSelectedItems();

    const scrollContainer = document.getElementById('cart-items-scroll');
    if (scrollContainer) {
        const items = Array.from(scrollContainer.querySelectorAll('.cart-item'));
        let revealBatchSize = 5;
        let revealedCount = Math.min(5, items.length);

        const spacer = document.getElementById('cart-virtual-spacer');

        const updateSpacer = () => {
            const visible = items.slice(0, revealedCount);
            let avg = 0;
            if (visible.length > 0) {
                const totalHeight = visible.reduce((sum, el) => sum + el.offsetHeight, 0);
                avg = totalHeight / visible.length;
            }
            const remaining = Math.max(items.length - revealedCount, 0);
            if (remaining === 0) {
                spacer.style.height = '0px';
                return;
            }
            const fallbackAvg = 1;
            const estimated = remaining * (avg || fallbackAvg) * 0.35;
            const clamped = Math.max(60, Math.min(estimated, 220));
            spacer.style.height = `${Math.round(clamped)}px`;
        };

        const revealMore = () => {
            const hiddenItems = Array.from(scrollContainer.querySelectorAll('.cart-item.hidden'));
            if (hiddenItems.length === 0) return;
            hiddenItems.slice(0, revealBatchSize).forEach(el => el.classList.remove('hidden'));
            revealedCount = Math.min(revealedCount + revealBatchSize, items.length);
            updateSpacer();
        };

        const onScroll = () => {
            if (scrollContainer.scrollTop + scrollContainer.clientHeight >= scrollContainer.scrollHeight - 10) {
                revealMore();
            }
        };

        scrollContainer.addEventListener('scroll', onScroll);

        setTimeout(updateSpacer, 0);
    }
});
</script>
@endpush
