<header class="bg-white shadow-sm border-b border-gray-200 sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Main Header -->
        <div class="flex justify-between items-center h-16">
            <!-- Logo Section -->
            <div class="flex items-center flex-shrink-0">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sun text-white text-xl"></i>
                    </div>
                    <div>
                        <h1 class="text-xl font-bold text-gray-900">Vegetable Store</h1>
                        <p class="text-xs text-gray-500">Rau củ quả tươi ngon</p>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex items-center space-x-6 lg:space-x-8">
                <a href="{{ route('home') }}" class="font-medium transition-colors duration-200 whitespace-nowrap {{ request()->routeIs('home') ? 'text-green-600 bg-green-50 px-3 py-1 rounded-lg' : 'text-gray-700 hover:text-green-600' }}">
                    Trang chủ
                </a>
                <a href="{{ route('products.index') }}" class="font-medium transition-colors duration-200 whitespace-nowrap {{ request()->routeIs('products.*') ? 'text-green-600 bg-green-50 px-3 py-1 rounded-lg' : 'text-gray-700 hover:text-green-600' }}">
                    Sản phẩm
                </a>
                <!-- Categories Dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" @mouseenter="open = true" @mouseleave="open = false"
                            class="font-medium transition-colors duration-200 whitespace-nowrap {{ request()->routeIs('categories.*') ? 'text-green-600 bg-green-50 px-3 py-1 rounded-lg' : 'text-gray-700 hover:text-green-600' }} flex items-center">
                        Danh mục
                        <i class="fas fa-chevron-down ml-1 text-xs"></i>
                    </button>

                    <!-- Dropdown Menu -->
                    <div x-show="open"
                         @click.away="open = false"
                         @mouseenter="open = true"
                         @mouseleave="open = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-lg py-2 z-50 border border-gray-200"
                         style="display: none;"
                         x-cloak>

                        <!-- All Categories -->
                        <a href="{{ route('products.index') }}"
                           class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors {{ !request()->get('category') ? 'bg-green-50 text-green-600' : '' }}">
                            <span>Tất cả danh mục</span>
                            <span class="text-xs text-gray-500">({{ $totalProducts }})</span>
                        </a>

                        <hr class="my-1">

                        <!-- Category List -->
                        @foreach($headerCategories as $category)
                            <a href="{{ route('products.index', ['category' => $category->id]) }}"
                               class="flex items-center justify-between px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors {{ request()->get('category') == $category->id ? 'bg-green-50 text-green-600' : '' }}">
                                <span>{{ $category->name }}</span>
                                <span class="text-xs text-gray-500">({{ $category->products_count }})</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </nav>

            <!-- Right Section -->
            <div class="flex items-center space-x-4">
                <!-- Cart (only for authenticated users) -->
                @auth
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-gray-700 hover:text-green-600 transition-colors duration-200">
                        <i class="fas fa-shopping-cart text-xl"></i>
                        @if(isset($cartItemsCount) && $cartItemsCount > 0)
                            <span class="cart-count absolute -top-1 -right-1 bg-green-600 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center font-bold">
                                {{ $cartItemsCount }}
                            </span>
                        @endif
                    </a>
                @endauth

                <!-- Auth Section -->
                <div class="flex items-center space-x-3">
                    @guest
                        <a href="{{ route('login') }}"
                           class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}"
                           class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200 shadow-sm">
                            <i class="fas fa-user-plus mr-2"></i>
                            Đăng ký
                        </a>
                    @else
                        <!-- User Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200">
                                <div class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mr-2">
                                    <i class="fas fa-user text-green-600 text-xs"></i>
                                </div>
                                <span class="hidden sm:block">{{ Auth::user()->full_name }}</span>
                                <i class="fas fa-chevron-down ml-2 text-xs"></i>
                            </button>

                            <!-- Dropdown Menu -->
                            <div x-show="open"
                                 @click.away="open = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-1 z-50 border border-gray-200"
                                 style="display: none;"
                                 x-cloak>
                <a href="{{ route('profile.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-user mr-3 text-gray-400"></i>
                                    Thông tin cá nhân
                                </a>
                                <a href="{{ route('orders.index') }}" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-shopping-bag mr-3 text-gray-400"></i>
                                    Đơn hàng của tôi
                                </a>
                                <a href="#" onclick="openChangePasswordModal(); return false;" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-key mr-3 text-gray-400"></i>
                                    Đổi mật khẩu
                                </a>
                                <hr class="my-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-2 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                        <i class="fas fa-sign-out-alt mr-3 text-gray-400"></i>
                                        Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Mobile menu button -->
                <button class="md:hidden inline-flex items-center p-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-all duration-200" x-data @click="$dispatch('toggle-mobile-menu')">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div class="md:hidden border-t border-gray-200 bg-white" x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-show="open" x-transition x-cloak>
            <div class="px-4 py-4 space-y-3">

                <!-- Mobile Navigation Links -->
                <div class="space-y-2">
                    <a href="{{ route('home') }}" class="flex items-center px-4 py-3 font-medium rounded-lg transition-colors {{ request()->routeIs('home') ? 'text-green-600 bg-green-100' : 'text-gray-700 hover:text-green-600 hover:bg-green-50' }}">
                        <i class="fas fa-home mr-3 {{ request()->routeIs('home') ? 'text-green-500' : 'text-gray-400' }}"></i>
                        Trang chủ
                    </a>
                    <a href="{{ route('products.index') }}" class="flex items-center px-4 py-3 font-medium rounded-lg transition-colors {{ request()->routeIs('products.*') ? 'text-green-600 bg-green-100' : 'text-gray-700 hover:text-green-600 hover:bg-green-50' }}">
                        <i class="fas fa-box mr-3 {{ request()->routeIs('products.*') ? 'text-green-500' : 'text-gray-400' }}"></i>
                        Sản phẩm
                    </a>
                    <!-- Mobile Categories -->
                    <div x-data="{ open: false }">
                        <button @click="open = !open"
                                class="flex items-center justify-between w-full px-4 py-3 font-medium rounded-lg transition-colors {{ request()->routeIs('categories.*') ? 'text-green-600 bg-green-100' : 'text-gray-700 hover:text-green-600 hover:bg-green-50' }}">
                            <div class="flex items-center">
                                <i class="fas fa-th-large mr-3 {{ request()->routeIs('categories.*') ? 'text-green-500' : 'text-gray-400' }}"></i>
                                Danh mục
                            </div>
                            <i class="fas fa-chevron-down text-xs transition-transform duration-200" :class="{ 'rotate-180': open }"></i>
                        </button>

                        <!-- Mobile Category List -->
                        <div x-show="open" x-transition class="ml-4 space-y-1">
                            <a href="{{ route('products.index') }}"
                               class="flex items-center justify-between px-4 py-2 text-sm rounded-lg transition-colors {{ !request()->get('category') ? 'text-green-600 bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                                <span>Tất cả danh mục</span>
                                <span class="text-xs text-gray-500">({{ $totalProducts }})</span>
                            </a>

                            @foreach($headerCategories as $category)
                                <a href="{{ route('products.index', ['category' => $category->id]) }}"
                                   class="flex items-center justify-between px-4 py-2 text-sm rounded-lg transition-colors {{ request()->get('category') == $category->id ? 'text-green-600 bg-green-50' : 'text-gray-600 hover:text-green-600 hover:bg-gray-50' }}">
                                    <span>{{ $category->name }}</span>
                                    <span class="text-xs text-gray-500">({{ $category->products_count }})</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <!-- Mobile Cart (only for authenticated users) -->
                    @auth
                        <a href="{{ route('cart.index') }}" class="flex items-center px-4 py-3 font-medium rounded-lg transition-colors {{ request()->routeIs('cart.*') ? 'text-green-600 bg-green-100' : 'text-gray-700 hover:text-green-600 hover:bg-green-50' }}">
                            <i class="fas fa-shopping-cart mr-3 {{ request()->routeIs('cart.*') ? 'text-green-500' : 'text-gray-400' }}"></i>
                            Giỏ hàng
                        </a>
                    @endauth
                </div>

                <!-- Mobile Auth Links -->
                @guest
                    <div class="pt-4 border-t border-gray-200 space-y-3">
                        <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-gray-700 hover:text-green-600 hover:bg-green-50 font-medium rounded-lg transition-colors">
                            <i class="fas fa-sign-in-alt mr-3 text-gray-400"></i>
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="flex items-center px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 font-medium transition-colors">
                            <i class="fas fa-user-plus mr-3"></i>
                            Đăng ký
                        </a>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</header>

<!-- Change Password Modal -->
@auth
<div id="change-password-modal" class="fixed inset-0 hidden z-[60]">
    <div class="absolute inset-0 backdrop-blur-sm" onclick="closeChangePasswordModal()"></div>
    <div class="relative max-w-md w-full mx-auto mt-24 bg-white rounded-xl shadow-2xl border border-gray-200">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-900">Đổi mật khẩu</h3>
            <button class="text-gray-400 hover:text-gray-600" onclick="closeChangePasswordModal()"><i class="fas fa-times"></i></button>
        </div>
        <div class="p-6 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu hiện tại</label>
                <input id="cp-current" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Mật khẩu mới</label>
                <input id="cp-new" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nhập lại mật khẩu mới</label>
                <input id="cp-new_confirmation" type="password" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
            </div>
            <div id="cp-error" class="hidden text-sm text-red-600"></div>
            <div class="flex items-center justify-end gap-3 pt-2">
                <button class="px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-lg" onclick="closeChangePasswordModal()">Hủy</button>
                <button id="cp-submit" class="px-5 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg" onclick="submitChangePassword(this)">Lưu</button>
            </div>
        </div>
    </div>
</div>
@endauth

@push('scripts')
<script>
// Fallback toast util if not present
if (typeof window.showNotification !== 'function') {
    window.showNotification = function(message, type) {
        const toast = document.createElement('div');
        toast.className = `fixed top-4 right-4 z-[70] px-6 py-3 rounded-lg shadow-lg transition-all duration-300 ${type === 'success' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'}`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
}
function openChangePasswordModal(){
    document.getElementById('cp-current').value='';
    document.getElementById('cp-new').value='';
    document.getElementById('cp-new_confirmation').value='';
    const err = document.getElementById('cp-error');
    err.textContent=''; err.classList.add('hidden');
    document.getElementById('change-password-modal').classList.remove('hidden');
    document.body.style.overflow='hidden';
}
function closeChangePasswordModal(){
    document.getElementById('change-password-modal').classList.add('hidden');
    document.body.style.overflow='';
}
function submitChangePassword(btn){
    const current_password = document.getElementById('cp-current').value.trim();
    const new_password = document.getElementById('cp-new').value.trim();
    const new_password_confirmation = document.getElementById('cp-new_confirmation').value.trim();
    const err = document.getElementById('cp-error');
    err.textContent=''; err.classList.add('hidden');
    if(!current_password || !new_password || !new_password_confirmation){
        err.textContent='Vui lòng nhập đầy đủ thông tin'; err.classList.remove('hidden'); return;
    }
    btn.disabled=true; const old=btn.innerHTML; btn.innerHTML='<i class="fas fa-spinner fa-spin mr-2"></i>Đang lưu...';
    fetch('{{ route('profile.change-password') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ current_password, new_password, new_password_confirmation })
    }).then(async r=>{
        const ct=r.headers.get('content-type')||''; const data=ct.includes('application/json')? await r.json(): {success:false,message:'Lỗi không xác định'};
        if(data.success){
            closeChangePasswordModal();
            if(window.showNotification){ showNotification('Đổi mật khẩu thành công', 'success'); }
        } else {
            err.textContent=data.message || 'Không thể đổi mật khẩu'; err.classList.remove('hidden');
        }
    }).catch(()=>{
        err.textContent='Có lỗi xảy ra, vui lòng thử lại'; err.classList.remove('hidden');
    }).finally(()=>{ btn.disabled=false; btn.innerHTML=old; });
}
</script>
@endpush
