@extends('layouts.app')

@section('title', 'Quên mật khẩu - Vegetable Store')

@section('content')
<div class="bg-gray-50 py-2 sm:px-4 lg:px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-2 text-center text-xl font-bold text-gray-900">
            Quên mật khẩu
        </h2>
        <p class="mt-0.5 text-center text-xs text-gray-600">
            Hoặc
            <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                quay lại đăng nhập
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

            <div class="mb-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                <div class="flex">
                    <i class="fas fa-info-circle text-blue-500 mr-2 mt-0.5"></i>
                    <p class="text-sm text-blue-700">
                        Nhập địa chỉ email của bạn và chúng tôi sẽ gửi link đặt lại mật khẩu.
                    </p>
                </div>
            </div>

            <form class="space-y-4" action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-envelope mr-1"></i>
                        Địa chỉ email
                    </label>
                    <div class="mt-1">
                        <input id="email"
                               name="email"
                               type="email"
                               autocomplete="email"
                               value="{{ old('email') }}"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('email') border-red-300 @enderror"
                               placeholder="Nhập địa chỉ email của bạn"
                               required>
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-paper-plane text-white"></i>
                        </span>
                        Gửi link đặt lại mật khẩu
                    </button>
                </div>
            </form>

            <div class="mt-4 text-center">
                <p class="text-sm text-gray-600">
                    Nhớ mật khẩu?
                    <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                        Đăng nhập ngay
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

