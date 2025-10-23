<footer class="bg-gray-900 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div class="space-y-4">
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center">
                        <i class="fas fa-sun text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold">Vegetable Store</h3>
                        <p class="text-sm text-gray-400">Rau củ quả tươi ngon</p>
                    </div>
                </div>
                <p class="text-gray-300 text-sm">
                    Chuyên cung cấp rau củ quả tươi ngon, chất lượng cao với giá cả hợp lý.
                    Giao hàng tận nơi, đảm bảo sức khỏe cho gia đình bạn.
                </p>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-green-400 transition-colors">
                        <i class="fab fa-twitter text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition-colors">
                        <i class="fab fa-facebook text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition-colors">
                        <i class="fab fa-pinterest text-xl"></i>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-green-400 transition-colors">
                        <i class="fab fa-instagram text-xl"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Liên kết nhanh</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('home') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Trang chủ
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('products.index') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Sản phẩm
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Danh mục
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Giới thiệu
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Liên hệ
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Categories -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Danh mục sản phẩm</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="{{ route('categories.show', 'rau-xanh') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Rau xanh
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.show', 'cu-qua') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Củ quả
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.show', 'trai-cay') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Trái cây
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.show', 'gia-vi') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Gia vị
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('categories.show', 'rau-thom') }}" class="text-gray-300 hover:text-green-400 transition-colors">
                            Rau thơm
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="space-y-4">
                <h3 class="text-lg font-semibold">Thông tin liên hệ</h3>
                <div class="space-y-3">
                    <div class="flex items-start space-x-3">
                        <i class="fas fa-map-marker-alt text-green-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-gray-300 text-sm">
                                123 Đường ABC, Quận 1<br>
                                TP. Hồ Chí Minh, Việt Nam
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center space-x-3">
                        <i class="fas fa-phone text-green-400 flex-shrink-0"></i>
                        <p class="text-gray-300 text-sm">0123 456 789</p>
                    </div>

                    <div class="flex items-center space-x-3">
                        <i class="fas fa-envelope text-green-400 flex-shrink-0"></i>
                        <p class="text-gray-300 text-sm">info@vegetablestore.com</p>
                    </div>

                    <div class="flex items-start space-x-3">
                        <i class="fas fa-clock text-green-400 mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-gray-300 text-sm">
                                Thứ 2 - Chủ nhật: 7:00 - 22:00<br>
                                <span class="text-green-400">Giao hàng 24/7</span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="border-t border-gray-800 mt-8 pt-8">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <div class="text-gray-400 text-sm">
                    © {{ date('Y') }} Vegetable Store. Tất cả quyền được bảo lưu.
                </div>
                <div class="flex space-x-6 text-sm">
                    <a href="{{ route('privacy') }}" class="text-gray-400 hover:text-green-400 transition-colors">
                        Chính sách bảo mật
                    </a>
                    <a href="{{ route('terms') }}" class="text-gray-400 hover:text-green-400 transition-colors">
                        Điều khoản sử dụng
                    </a>
                    <a href="{{ route('refund') }}" class="text-gray-400 hover:text-green-400 transition-colors">
                        Chính sách đổi trả
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>
