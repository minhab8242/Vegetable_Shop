@extends('admin.layout')

@section('title', 'Chỉnh sửa khách hàng')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Chỉnh sửa khách hàng</h1>
                <p class="text-gray-600">Cập nhật thông tin khách hàng</p>
            </div>
            <a href="{{ route('admin.customers.show', $customer) }}"
               class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Quay lại
            </a>
        </div>
    </div>

    <!-- Edit Form -->
    <div class="max-w-2xl">
        <div class="bg-white rounded-lg shadow">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">Thông tin khách hàng</h3>
            </div>

            <form action="{{ route('admin.customers.update', $customer) }}" method="POST" class="p-6">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6">
                    <!-- Full Name -->
                    <div>
                        <label for="full_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Họ tên <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               id="full_name"
                               name="full_name"
                               value="{{ old('full_name', $customer->full_name) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('full_name') border-red-500 @enderror"
                               required>
                        @error('full_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email (Read-only) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email"
                               id="email"
                               value="{{ $customer->email }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md bg-gray-100"
                               readonly>
                        <p class="mt-1 text-sm text-gray-500">Email không thể thay đổi</p>
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">Số điện thoại</label>
                        <input type="text"
                               id="phone"
                               name="phone"
                               value="{{ old('phone', $customer->phone) }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('phone') border-red-500 @enderror">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Địa chỉ</label>
                        <textarea id="address"
                                  name="address"
                                  rows="3"
                                  class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 @error('address') border-red-500 @enderror">{{ old('address', $customer->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="mt-8 flex justify-end space-x-3">
                    <a href="{{ route('admin.customers.show', $customer) }}"
                       class="bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition-colors">
                        Hủy
                    </a>
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i>Cập nhật
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
