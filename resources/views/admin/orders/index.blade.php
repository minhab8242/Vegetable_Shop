@extends('admin.layout')

@section('title', 'Quản lý đơn hàng')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-900">Quản lý đơn hàng</h1>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-4">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-shopping-cart text-gray-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Tổng đơn hàng</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $stats['total'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-clock text-yellow-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Chờ xử lý</p>
                    <p class="text-2xl font-semibold text-yellow-600">{{ $stats['pending'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-circle text-blue-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Đã xác nhận</p>
                    <p class="text-2xl font-semibold text-blue-600">{{ $stats['confirmed'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-truck text-purple-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Đang giao</p>
                    <p class="text-2xl font-semibold text-purple-600">{{ $stats['shipping'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-check-double text-green-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Hoàn thành</p>
                    <p class="text-2xl font-semibold text-green-600">{{ $stats['completed'] }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-times-circle text-red-400 text-2xl"></i>
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-500">Đã hủy</p>
                    <p class="text-2xl font-semibold text-red-600">{{ $stats['cancelled'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <form method="GET" action="{{ route('admin.orders') }}" class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search by customer name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tìm kiếm khách hàng</label>
                    <input type="text" name="search" value="{{ $filters['search'] ?? '' }}"
                           placeholder="Nhập tên khách hàng..."
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Filter by status -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Trạng thái</label>
                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                        <option value="">Tất cả trạng thái</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ ($filters['status'] ?? '') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Date from -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Từ ngày</label>
                    <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <!-- Date to -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Đến ngày</label>
                    <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}"
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>
            </div>

            <div class="flex items-center space-x-4">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-search mr-2"></i>
                    Tìm kiếm
                </button>
                <a href="{{ route('admin.orders') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium">
                    <i class="fas fa-times mr-2"></i>
                    Xóa bộ lọc
                </a>
            </div>
        </form>
    </div>

    <!-- Search Results Info -->
    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <i class="fas fa-filter text-blue-600 mr-2"></i>
                    <span class="text-blue-800 font-medium">
                        Đang hiển thị {{ $orders->count() }} đơn hàng
                        @if($filters['search'])
                            với khách hàng "{{ $filters['search'] }}"
                        @endif
                        @if($filters['status'])
                            có trạng thái "{{ $statuses[$filters['status']] }}"
                        @endif
                        @if($filters['date_from'] || $filters['date_to'])
                            từ {{ $filters['date_from'] ?: 'đầu' }} đến {{ $filters['date_to'] ?: 'cuối' }}
                        @endif
                    </span>
                </div>
                <a href="{{ route('admin.orders') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                    <i class="fas fa-times mr-1"></i>
                    Xóa bộ lọc
                </a>
            </div>
        </div>
    @endif

    <!-- Orders Table -->
    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mã đơn hàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Khách hàng</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tổng tiền</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Trạng thái</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ngày đặt</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Thao tác</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">#{{ $order->id }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $order->user->full_name }}</div>
                                <div class="text-sm text-gray-500">{{ $order->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ number_format($order->total_amount, 0, ',', '.') }} VND</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
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
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $order->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.orders.show', $order) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-shopping-cart text-4xl mb-4"></i>
                                <p>Chưa có đơn hàng nào</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($orders->hasPages())
            <div class="px-6 py-3 border-t border-gray-200">
                {{ $orders->appends(request()->query())->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
