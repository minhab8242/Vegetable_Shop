@extends('layouts.app')

@section('title', 'Đăng ký - Vegetable Store')

@section('content')
<div class="bg-gray-50 py-2 sm:px-4 lg:px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <!-- Logo -->


        <h2 class="mt-2 text-center text-xl font-bold text-gray-900">
            Tạo tài khoản mới
        </h2>
        <p class="mt-0.5 text-center text-xs text-gray-600">
            Hoặc
            <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                đăng nhập với tài khoản hiện có
            </a>
        </p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-6 px-4 shadow sm:rounded-lg sm:px-10">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-3 bg-green-50 border border-green-200 text-green-700 px-3 py-2 rounded-md">
                    <div class="flex">
                        <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-3 bg-red-50 border border-red-200 text-red-700 px-3 py-2 rounded-md">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            <form class="space-y-4" action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-user mr-1"></i>
                        Họ và tên <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="full_name"
                               name="full_name"
                               type="text"
                               autocomplete="name"
                               value="{{ old('full_name') }}"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('full_name') border-red-300 @enderror"
                               placeholder="Nhập họ và tên đầy đủ">
                    </div>
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-1"></i>
                        Địa chỉ email <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="email"
                               name="email"
                               type="email"
                               autocomplete="email"
                               value="{{ old('email') }}"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-300 @enderror"
                               placeholder="Nhập địa chỉ email của bạn">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-1"></i>
                        Mật khẩu <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="password"
                               name="password"
                               type="password"
                               autocomplete="new-password"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-300 @enderror"
                               placeholder="Nhập mật khẩu (ít nhất 6 ký tự)">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-1"></i>
                        Xác nhận mật khẩu <span class="text-red-500">*</span>
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               autocomplete="new-password"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password_confirmation') border-red-300 @enderror"
                               placeholder="Nhập lại mật khẩu">
                    </div>
                    @error('password_confirmation')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-phone mr-1"></i>
                        Số điện thoại
                    </label>
                    <div class="mt-1">
                        <input id="phone"
                               name="phone"
                               type="tel"
                               autocomplete="tel"
                               value="{{ old('phone') }}"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('phone') border-red-300 @enderror"
                               placeholder="Nhập số điện thoại (không bắt buộc)">
                    </div>
                    @error('phone')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-map-marker-alt mr-1"></i>
                        Địa chỉ
                    </label>
                    <div class="mt-1">
                        <input id="address"
                               name="address"
                               type="text"
                               value="{{ old('address') }}"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('address') border-red-300 @enderror"
                               placeholder="Nhập địa chỉ (không bắt buộc)">
                    </div>
                    @error('address')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-center">
                        <input id="terms"
                               name="terms"
                               type="checkbox"
                               required
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="terms" class="ml-2 block text-sm text-gray-700">
                        Tôi đồng ý với
                        <a href="#" class="text-green-600 hover:text-green-500 transition-colors">Điều khoản sử dụng</a>
                        và
                        <a href="#" class="text-green-600 hover:text-green-500 transition-colors">Chính sách bảo mật</a>
                    </label>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-user-plus text-white "></i>
                        </span>
                        Tạo tài khoản
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection
