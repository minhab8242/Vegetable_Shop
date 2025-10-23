@extends('layouts.app')

@section('title', 'Đơn hàng của tôi')
@section('description', 'Danh sách đơn hàng bạn đã đặt')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-900">Đơn hàng của tôi</h1>
        <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-700 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Tiếp tục mua sắm
        </a>
    </div>

    @if($orders->isEmpty())
        <div class="bg-white rounded-xl shadow-sm p-8 text-center">
            <i class="fas fa-box-open text-gray-400 text-5xl mb-4"></i>
            <h3 class="text-lg font-semibold text-gray-900 mb-2">Bạn chưa có đơn hàng nào</h3>
            <p class="text-gray-600">Hãy bắt đầu đặt hàng ngay hôm nay!</p>
            <a href="{{ route('products.index') }}" class="inline-flex items-center mt-6 px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                Mua sắm ngay
                <i class="fas fa-arrow-right ml-2"></i>
            </a>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500">
                            <th class="py-3 px-6">Mã đơn</th>
                            <th class="py-3 px-6">Ngày đặt</th>
                            <th class="py-3 px-6">Trạng thái</th>
                            <th class="py-3 px-6">Tổng tiền</th>
                            <th class="py-3 px-6 text-right">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm text-gray-700">
                        @php
                            $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-700',
                                'confirmed' => 'bg-blue-100 text-blue-700',
                                'shipping' => 'bg-purple-100 text-purple-700',
                                'completed' => 'bg-green-100 text-green-700',
                                'cancelled' => 'bg-red-100 text-red-700',
                            ];
                        @endphp
                        @foreach($orders as $order)
                            <tr class="border-t">
                                <td class="py-3 px-6 font-medium">#{{ $order->id }}</td>
                                <td class="py-3 px-6">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                <td class="py-3 px-6">
                                    <span class="px-3 py-1 rounded-full text-xs font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-6 font-bold text-green-600">{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                                <td class="py-3 px-6 text-right">
                                    <div class="flex items-center justify-end space-x-2">
                                        <a href="{{ route('orders.show', $order->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg border border-gray-300 hover:bg-gray-50">
                                            Xem chi tiết
                                            <i class="fas fa-chevron-right ml-2 text-xs"></i>
                                        </a>
                                        @if($order->status === 'shipping')
                                            <form action="{{ route('orders.receive', $order->id) }}" method="POST" class="inline" onsubmit="return confirm('Bạn đã nhận được hàng?')">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-green-600 hover:bg-green-700 text-white">
                                                    <i class="fas fa-check mr-1"></i>
                                                    Đã nhận hàng
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
