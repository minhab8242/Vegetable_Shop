@extends('admin.layout')

@section('title', 'Chi tiết đơn hàng #' . $order->id)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Chi tiết đơn hàng #{{ $order->id }}</h1>
            <p class="text-gray-600 mt-1">Đặt lúc {{ $order->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <a href="{{ route('admin.orders') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Quay lại
        </a>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-check-circle text-green-600 mr-2"></i>
                <span class="text-green-800 font-medium">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Info -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Customer Info -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin khách hàng</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Họ tên</label>
                        <p class="text-sm text-gray-900">{{ $order->user->full_name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-sm text-gray-900">{{ $order->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Số điện thoại</label>
                        <p class="text-sm text-gray-900">{{ $order->user->phone ?? 'Chưa cập nhật' }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Địa chỉ</label>
                        <p class="text-sm text-gray-900">{{ $order->user->address ?? 'Chưa cập nhật' }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Sản phẩm trong đơn hàng</h3>
                <div class="space-y-4">
                    @foreach($order->orderDetails as $detail)
                        <div class="flex items-center space-x-4 p-4 border border-gray-200 rounded-lg">
                            <div class="flex-shrink-0">
                                <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-200 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-leaf text-green-400 text-xl"></i>
                                </div>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h4 class="text-sm font-medium text-gray-900">{{ $detail->product_name }}</h4>
                                @if($detail->product_description)
                                    <p class="text-sm text-gray-500 mt-1">{{ Str::limit($detail->product_description, 100) }}</p>
                                @endif
                                <div class="flex items-center space-x-4 mt-2">
                                    <span class="text-sm text-gray-500">Số lượng: {{ $detail->quantity }}</span>
                                    <span class="text-sm text-gray-500">Giá: {{ number_format($detail->price, 0, ',', '.') }} VND</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-medium text-gray-900">{{ number_format($detail->subtotal, 0, ',', '.') }} VND</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="space-y-6">
            <!-- Order Status -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Trạng thái đơn hàng</h3>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500">Trạng thái hiện tại</span>
                        @php
                            $statusColor = match($order->status) {
                                'pending' => 'yellow',
                                'confirmed' => 'blue',
                                'shipping' => 'purple',
                                'completed' => 'green',
                                'cancelled' => 'red',
                                default => 'gray'
                            };
                        @endphp
                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-{{ $statusColor }}-100 text-{{ $statusColor }}-800">
                            {{ $statuses[$order->status] }}
                        </span>
                    </div>

                    <!-- Update Status Form -->
                    <form action="{{ route('admin.orders.update-status', $order) }}" method="POST" class="space-y-3">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Cập nhật trạng thái</label>
                            <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                                @foreach($statuses as $key => $label)
                                    <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                            <i class="fas fa-save mr-2"></i>
                            Cập nhật trạng thái
                        </button>
                    </form>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Tóm tắt đơn hàng</h3>
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Số sản phẩm</span>
                        <span class="text-sm font-medium">{{ $order->orderDetails->sum('quantity') }} sản phẩm</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-600">Tổng tiền</span>
                        <span class="text-sm font-medium">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                    </div>
                    <div class="border-t pt-3">
                        <div class="flex justify-between">
                            <span class="text-base font-semibold text-gray-900">Tổng cộng</span>
                            <span class="text-base font-semibold text-green-600">{{ number_format($order->total_amount, 0, ',', '.') }} VND</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Timeline -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Lịch sử đơn hàng</h3>
                <div class="space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="flex-shrink-0">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-900">Đơn hàng được tạo</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    @if($order->updated_at != $order->created_at)
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Cập nhật lần cuối</p>
                                <p class="text-xs text-gray-500">{{ $order->updated_at->format('d/m/Y H:i') }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
