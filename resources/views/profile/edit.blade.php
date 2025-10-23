@extends('layouts.app')

@section('title', 'Cập nhật thông tin cá nhân')
@section('description', 'Cập nhật thông tin cá nhân của bạn')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <a href="{{ route('cart.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">
                <i class="fas fa-arrow-left"></i>
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Cập nhật thông tin cá nhân</h1>
        </div>
        <p class="text-gray-600">Cập nhật thông tin cá nhân để tiếp tục thanh toán</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Profile Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Họ và tên <span class="text-red-500">*</span>
                    </label>
                    <input type="text"
                           id="full_name"
                           name="full_name"
                           value="{{ old('full_name', $user->full_name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('full_name') border-red-500 @enderror"
                           placeholder="Nhập họ và tên của bạn"
                           required>
                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email (Read-only) -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-green-600"></i>
                        Email
                    </label>
                    <input type="email"
                           id="email"
                           value="{{ $user->email }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600"
                           readonly>
                    <p class="text-gray-500 text-sm mt-1">Email không thể thay đổi</p>
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-green-600"></i>
                        Số điện thoại
                    </label>
                    <input type="tel"
                           id="phone"
                           name="phone"
                           value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('phone') border-red-500 @enderror"
                           placeholder="Nhập số điện thoại của bạn">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-map-marker-alt mr-2 text-green-600"></i>
                        Địa chỉ
                    </label>
                    <textarea id="address"
                              name="address"
                              rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('address') border-red-500 @enderror"
                              placeholder="Nhập địa chỉ của bạn">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <a href="{{ route('cart.index') }}"
                       class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-3 rounded-lg font-semibold transition-colors text-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Quay lại giỏ hàng
                    </a>
                    <button type="submit"
                            class="flex-1 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition-colors">
                        <i class="fas fa-save mr-2"></i>
                        Cập nhật thông tin
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Information Notice -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <i class="fas fa-info-circle text-blue-600 mr-3 mt-1"></i>
            <div>
                <h3 class="text-blue-800 font-medium mb-1">Thông tin cần thiết</h3>
                <p class="text-blue-700 text-sm">
                    Để thanh toán, bạn cần cung cấp đầy đủ thông tin: Họ tên, Số điện thoại và Địa chỉ.
                    Thông tin này sẽ được sử dụng để giao hàng.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
