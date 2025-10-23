@extends('layouts.app')

@section('title', 'Đặt lại mật khẩu - Vegetable Store')

@section('content')
<div class="bg-gray-50 py-2 sm:px-4 lg:px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-2 text-center text-xl font-bold text-gray-900">
            Đặt lại mật khẩu
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
                        Nhập mật khẩu mới cho tài khoản: <strong>{{ $email }}</strong>
                    </p>
                </div>
            </div>

            <form class="space-y-4" action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="hidden" name="email" value="{{ $email }}">

                <!-- New Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">
                        <i class="fas fa-lock mr-1"></i>
                        Mật khẩu mới
                    </label>
                    <div class="mt-1">
                        <input id="password"
                               name="password"
                               type="password"
                               autocomplete="new-password"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-300 @enderror"
                               placeholder="Nhập mật khẩu mới"
                               required>
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
                        Xác nhận mật khẩu mới
                    </label>
                    <div class="mt-1">
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               autocomplete="new-password"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password_confirmation') border-red-300 @enderror"
                               placeholder="Nhập lại mật khẩu mới"
                               required>
                    </div>
                    @error('password_confirmation')
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
                            <i class="fas fa-key text-white"></i>
                        </span>
                        Đặt lại mật khẩu
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

