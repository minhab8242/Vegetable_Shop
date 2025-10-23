@extends('admin.layout')

@section('title', 'Chi tiết khách hàng')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Chi tiết khách hàng</h1>
                <p class="text-gray-600">Thông tin chi tiết và lịch sử đơn hàng</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.customers.edit', $customer) }}"
                   class="bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 transition-colors">
                    <i class="fas fa-edit mr-2"></i>Chỉnh sửa
                </a>
                <a href="{{ route('admin.customers.index') }}"
                   class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>Quay lại
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Customer Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Thông tin khách hàng</h3>
                </div>
                <div class="p-6">
                    <div class="flex items-center mb-6">
                        <div class="h-16 w-16 rounded-full bg-gray-300 flex items-center justify-center">
                            <i class="fas fa-user text-gray-600 text-2xl"></i>
                        </div>
                        <div class="ml-4">
                            <h4 class="text-xl font-semibold text-gray-900">{{ $customer->full_name }}</h4>
                            <p class="text-gray-500">{{ $customer->email }}</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Họ tên</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->full_name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Số điện thoại</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->phone ?? 'Chưa cập nhật' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Địa chỉ</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->address ?? 'Chưa cập nhật' }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Ngày đăng ký</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->created_at->format('d/m/Y H:i') }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tổng đơn hàng</label>
                            <p class="mt-1 text-sm text-gray-900">{{ $customer->orders()->count() }} đơn</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders History -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Lịch sử đơn hàng</h3>
                </div>

                @if($orders->count() > 0)
                    <div class="divide-y divide-gray-200">
                        @foreach($orders as $order)
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h4 class="text-lg font-medium text-gray-900">Đơn hàng #{{ $order->id }}</h4>
                                        <p class="text-sm text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-semibold text-gray-900">{{ number_format($order->total_amount, 0, ',', '.') }} VND</p>
                                        @php
                                            $statusColor = match($order->status) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'confirmed' => 'bg-blue-100 text-blue-800',
                                                'shipping' => 'bg-purple-100 text-purple-800',
                                                'completed' => 'bg-green-100 text-green-800',
                                                'cancelled' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            };
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </div>
                                </div>

                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex justify-between items-center">
                                        <span class="text-sm text-gray-500">{{ $order->orderDetails->count() }} sản phẩm</span>
                                        <a href="{{ route('admin.orders.show', $order) }}"
                                           class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                            Xem chi tiết <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($orders->hasPages())
                        <div class="px-6 py-4 border-t border-gray-200">
                            {{ $orders->links() }}
                        </div>
                    @endif
                @else
                    <div class="px-6 py-12 text-center">
                        <i class="fas fa-shopping-cart text-gray-300 text-4xl mb-4"></i>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Chưa có đơn hàng</h3>
                        <p class="text-gray-500">Khách hàng này chưa có đơn hàng nào.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
