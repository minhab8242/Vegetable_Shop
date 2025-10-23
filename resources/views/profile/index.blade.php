@extends('layouts.app')

@section('title', 'Thông tin cá nhân')
@section('description', 'Xem và cập nhật thông tin cá nhân')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900">Thông tin cá nhân</h1>
        <p class="text-gray-600">Cập nhật thông tin của bạn. Email không thể thay đổi.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-6">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6">
            <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-green-600"></i>
                        Họ và tên <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('full_name') border-red-500 @enderror"
                           placeholder="Nhập họ và tên" required>
                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-envelope mr-2 text-green-600"></i>
                        Email
                    </label>
                    <input type="email" value="{{ $user->email }}" class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-600" readonly>
                    <p class="text-gray-500 text-sm mt-1">Email không thể thay đổi</p>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-phone mr-2 text-green-600"></i>
                        Số điện thoại
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $user->phone) }}"
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('phone') border-red-500 @enderror"
                           placeholder="Nhập số điện thoại">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas a-map-marker-alt mr-2 text-green-600"></i>
                        Địa chỉ
                    </label>
                    <textarea id="address" name="address" rows="3"
                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors @error('address') border-red-500 @enderror"
                              placeholder="Nhập địa chỉ">{{ old('address', $user->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-200">
                    <a href="{{ route('orders.index') }}" class="px-5 py-3 bg-gray-100 hover:bg-gray-200 rounded-lg">Đơn hàng của tôi</a>
                    <button type="submit" class="px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg">Lưu thay đổi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
