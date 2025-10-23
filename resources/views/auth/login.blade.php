@extends('layouts.app')

@section('title', 'Đăng nhập - Vegetable Store')

@section('content')
<div class="bg-gray-50 py-2 sm:px-4 lg:px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">

        <h2 class="mt-2 text-center text-xl font-bold text-gray-900">
            Đăng nhập tài khoản
        </h2>
        <p class="mt-0.5 text-center text-xs text-gray-600">
            Hoặc
            <a href="{{ route('register') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                tạo tài khoản mới
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

            <form class="space-y-4" action="{{ route('login') }}" method="POST">
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
                        Mật khẩu
                    </label>
                    <div class="mt-1">
                        <input id="password"
                               name="password"
                               type="password"
                               autocomplete="current-password"
                               class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 @error('password') border-red-300 @enderror"
                               placeholder="Nhập mật khẩu của bạn">
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">
                            <i class="fas fa-exclamation-triangle mr-1"></i>
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember"
                               name="remember"
                               type="checkbox"
                               class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 block text-sm text-gray-700">
                            Ghi nhớ đăng nhập
                        </label>
                    </div>

                    <div class="text-sm">
                        <a href="{{ route('password.request') }}" class="font-medium text-green-600 hover:text-green-500 transition-colors">
                            Quên mật khẩu?
                        </a>
                    </div>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                            class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                            <i class="fas fa-sign-in-alt text-white "></i>
                        </span>
                        Đăng nhập
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const emailInput = document.getElementById('email');
    const passwordInput = document.getElementById('password');
    const rememberCheckbox = document.getElementById('remember');

    const savedEmail = localStorage.getItem('savedEmail');
    const savedPassword = localStorage.getItem('savedPassword');

    if (savedEmail && savedPassword) {
        emailInput.value = savedEmail;
        passwordInput.value = savedPassword;
        rememberCheckbox.checked = true;
    }

    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        if (rememberCheckbox.checked) {
            localStorage.setItem('savedEmail', emailInput.value);
            localStorage.setItem('savedPassword', passwordInput.value);
        } else {
            localStorage.removeItem('savedEmail');
            localStorage.removeItem('savedPassword');
        }
    });
});
</script>
@endpush
@endsection
