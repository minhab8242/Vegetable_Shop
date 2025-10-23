<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Đăng nhập Admin - Vegetable Store</title>
    <meta name="description" content="Đăng nhập vào hệ thống quản lý Vegetable Store">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-gray-50 font-sans antialiased flex items-center justify-center">
    <div class="max-w-md w-full mx-auto">
        <div class="bg-white rounded-xl shadow-lg p-8">
            <!-- Header -->
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-shield-alt text-white text-2xl"></i>
                </div>
                <h1 class="text-2xl font-bold text-gray-900">Admin Panel</h1>
                <p class="text-gray-600 mt-2">Đăng nhập để quản lý hệ thống</p>
            </div>

            <!-- Login Form -->
            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-6">
                @csrf

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-gray-400"></i>
                        Email
                    </label>
                    <input type="email"
                           id="email"
                           name="email"
                           value="{{ old('email') }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('email') border-red-500 @enderror"
                           placeholder="Nhập email admin"
                           required>
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-gray-400"></i>
                        Mật khẩu
                    </label>
                    <input type="password"
                           id="password"
                           name="password"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('password') border-red-500 @enderror"
                           placeholder="Nhập mật khẩu"
                           required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <button type="submit"
                        class="w-full bg-green-600 hover:bg-green-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    <i class="fas fa-sign-in-alt mr-2"></i>
                    Đăng nhập
                </button>
            </form>

            <!-- Back to Site -->
            <div class="mt-8 text-center">
                <a href="{{ route('home') }}"
                   class="text-gray-600 hover:text-green-600 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Quay lại trang chủ
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-6 text-gray-500 text-sm">
            <p>&copy; 2024 Vegetable Store. All rights reserved.</p>
        </div>
    </div>

    <!-- Notification Toast -->
    <div id="notification" class="fixed top-4 right-4 z-50 hidden">
        <div class="bg-white border border-gray-200 rounded-lg shadow-lg p-4 max-w-sm">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-green-500" id="notification-icon"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-gray-900" id="notification-message"></p>
                </div>
                <div class="ml-auto pl-3">
                    <button onclick="hideNotification()" class="text-gray-400 hover:text-gray-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    @stack('scripts')

    <script>
        @if(session('success'))
            showNotification('{{ session('success') }}', 'success');
        @endif

        @if(session('error'))
            showNotification('{{ session('error') }}', 'error');
        @endif

        function showNotification(message, type) {
            const notification = document.getElementById('notification');
            const icon = document.getElementById('notification-icon');
            const messageEl = document.getElementById('notification-message');

            messageEl.textContent = message;

            if (type === 'success') {
                icon.className = 'fas fa-check-circle text-green-500';
            } else {
                icon.className = 'fas fa-exclamation-circle text-red-500';
            }

            notification.classList.remove('hidden');
            setTimeout(hideNotification, 5000);
        }

        function hideNotification() {
            document.getElementById('notification').classList.add('hidden');
        }
    </script>
</body>
</html>
