@extends('layouts.app')

@section('title', 'Chi tiết đơn hàng')
@section('description', 'Chi tiết đơn hàng của bạn')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Đơn hàng #{{ $order->id }}</h1>
            <div class="text-sm text-gray-500 mt-1">Ngày đặt: {{ $order->created_at->format('d/m/Y H:i') }}</div>
        </div>
        <a href="{{ route('orders.index') }}" class="text-gray-600 hover:text-gray-800 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Quay lại danh sách
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                    <div class="space-y-1">
                        <div class="text-sm text-gray-500">Trạng thái</div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'shipping' => 'bg-purple-100 text-purple-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Tổng tiền</div>
                        <div class="text-xl font-bold text-green-600">{{ number_format($order->total_amount, 0, ',', '.') }} VND</div>
                    </div>
                </div>

                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="text-left text-sm text-gray-500">
                                    <th class="py-2 pr-4">Sản phẩm</th>
                                    <th class="py-2 pr-4">Giá</th>
                                    <th class="py-2 pr-4">Số lượng</th>
                                    <th class="py-2 pr-4">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm text-gray-700">
                                @foreach($order->orderDetails as $detail)
                                    <tr class="border-t">
                                        <td class="py-3 pr-4">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                                    <div class="w-full h-full flex items-center justify-center">
                                                        <i class="fas fa-leaf text-green-400"></i>
                                                    </div>
                                                </div>
                                                <div>
                                                    <div class="font-medium">{{ $detail->product_name }}</div>
                                                    @if($detail->product_description)
                                                        <div class="text-xs text-gray-500">{{ Str::limit($detail->product_description, 60) }}</div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 pr-4">{{ number_format($detail->price, 0, ',', '.') }} VND</td>
                                        <td class="py-3 pr-4">{{ $detail->quantity }}</td>
                                        <td class="py-3 pr-4 font-semibold">{{ number_format($detail->price * $detail->quantity, 0, ',', '.') }} VND</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Thông tin người nhận</h3>
                <div class="space-y-2 text-sm text-gray-700">
                    <div><span class="text-gray-500">Họ tên:</span> <span class="font-medium">{{ $order->user->full_name }}</span></div>
                    <div><span class="text-gray-500">Email:</span> <span class="font-medium">{{ $order->user->email }}</span></div>
                    @if($order->user->phone)
                        <div><span class="text-gray-500">SĐT:</span> <span class="font-medium">{{ $order->user->phone }}</span></div>
                    @endif
                    @if($order->user->address)
                        <div><span class="text-gray-500">Địa chỉ:</span> <span class="font-medium">{{ $order->user->address }}</span></div>
                    @endif
                </div>
            </div>

            @if($order->status === 'shipping')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mt-4">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Xác nhận nhận hàng</h3>
                    <p class="text-sm text-gray-600 mb-4">Nếu bạn đã nhận được hàng, vui lòng xác nhận để hoàn tất đơn hàng.</p>
                    <form action="{{ route('orders.receive', $order->id) }}" method="POST" onsubmit="return confirm('Bạn đã nhận được hàng?')">
                        @csrf
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-medium">
                            <i class="fas fa-check mr-2"></i>
                            Đã nhận được hàng
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
