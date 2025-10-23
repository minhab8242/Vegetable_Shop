@extends('layouts.app')

@section('title', 'Xác thực Email - Vegetable Store')

@section('content')
<div class="bg-gray-50 py-2 sm:px-4 lg:px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <h2 class="mt-2 text-center text-xl font-bold text-gray-900">
            Xác thực Email
        </h2>
        <p class="mt-0.5 text-center text-xs text-gray-600">
            Vui lòng xác thực địa chỉ email của bạn
        </p>
    </div>

    <div class="mt-6 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-6 px-4 shadow sm:rounded-lg sm:px-10">
            <!-- Success/Error Messages -->
            @if (session('success'))
                <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if (session('info'))
                <div class="mb-4 bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-lg">
                    <div class="flex">
                        <i class="fas fa-info-circle mr-2 mt-0.5"></i>
                        {{ session('info') }}
                    </div>
                </div>
            @endif

            <!-- Email Icon -->
            <div class="text-center mb-6">
                <div class="mx-auto w-16 h-16 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="fas fa-envelope text-green-600 text-2xl"></i>
                </div>
            </div>

            <!-- Instructions -->
            <div class="text-center mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    @if(session('error'))
                        Xác thực email bắt buộc
                    @else
                        Kiểm tra hộp thư của bạn
                    @endif
                </h3>
                <p class="text-sm text-gray-600">
                    @if(session('error'))
                        {{ session('error') }}
                    @else
                        Chúng tôi đã gửi một email xác thực đến địa chỉ email bạn đã đăng ký.
                        Vui lòng kiểm tra hộp thư (bao gồm cả thư mục spam) và nhấn vào link xác thực.
                    @endif
                </p>
            </div>

            <!-- Resend Email Form -->
            @auth
                <form action="{{ route('verification.resend') }}" method="POST" class="space-y-4">
                    @csrf

                    <div class="text-center">
                        <p class="text-sm text-gray-600 mb-4">
                            Không nhận được email? Vui lòng nhấn nút bên dưới để gửi lại.
                        </p>

                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                            <i class="fas fa-paper-plane mr-2"></i>
                            Gửi lại email xác thực
                        </button>
                    </div>
                </form>
            @else
                <div class="text-center">
                    <p class="text-sm text-gray-600 mb-4">
                        Bạn cần đăng nhập để gửi lại email xác thực.
                    </p>

                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Đăng nhập
                    </a>
                </div>
            @endauth

            <!-- Help Section -->
            <div class="mt-8 pt-6 border-t border-gray-200">
                <h4 class="text-sm font-medium text-gray-900 mb-3">
                    <i class="fas fa-question-circle mr-1"></i>
                    Cần hỗ trợ?
                </h4>
                <ul class="text-xs text-gray-600 space-y-2">
                    <li>• Kiểm tra thư mục spam/junk trong hộp thư</li>
                    <li>• Đảm bảo địa chỉ email được nhập chính xác</li>
                    <li>• Link xác thực có hiệu lực trong 24 giờ</li>
                    <li>• Liên hệ hỗ trợ nếu vẫn gặp vấn đề</li>
                </ul>
            </div>

            <!-- Back to Home -->
            <div class="mt-6 text-center">
                <a href="{{ route('home') }}"
                   class="text-sm text-green-600 hover:text-green-500 transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i>
                    Quay về trang chủ
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
