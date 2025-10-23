@extends('admin.layout')

@section('title', 'Tổng quan')

@section('content')
<div class="space-y-6">
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Tổng sản phẩm</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['products'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Tổng danh mục</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['categories'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Tổng đơn hàng</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['orders'] ?? 0 }}</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Tổng khách hàng</div>
            <div class="text-2xl font-bold mt-1">{{ $stats['customers'] ?? 0 }}</div>
        </div>
    </div>

    <!-- Revenue & Profit Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Tổng doanh thu</div>
            <div class="text-2xl font-bold mt-1 text-green-600">{{ number_format($totalRevenue ?? 0, 0, ',', '.') }} VND</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Tổng lợi nhuận</div>
            <div class="text-2xl font-bold mt-1 text-blue-600">{{ number_format($totalProfit ?? 0, 0, ',', '.') }} VND</div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Tỷ lệ lợi nhuận</div>
            <div class="text-2xl font-bold mt-1 text-purple-600">
                {{ $totalRevenue > 0 ? number_format(($totalProfit / $totalRevenue) * 100, 1) : 0 }}%
            </div>
        </div>
        <div class="bg-white rounded-xl border border-gray-200 p-5">
            <div class="text-gray-500 text-sm">Đơn hàng trung bình</div>
            <div class="text-2xl font-bold mt-1 text-orange-600">
                {{ $stats['orders'] > 0 ? number_format($totalRevenue / $stats['orders'], 0, ',', '.') : 0 }} VND
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Orders Chart -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Đơn hàng theo ngày</h3>
                <div class="flex space-x-2">
                    <select id="ordersPeriod" class="text-sm border border-gray-300 rounded px-2 py-1">
                        <option value="30">30 ngày</option>
                        <option value="7">7 ngày</option>
                        <option value="90">90 ngày</option>
                    </select>
                </div>
            </div>
            <div style="height: 300px;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>

        <!-- Revenue Chart -->
        <div class="bg-white rounded-xl border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold">Doanh thu theo ngày</h3>
                <div class="flex space-x-2">
                    <select id="revenuePeriod" class="text-sm border border-gray-300 rounded px-2 py-1">
                        <option value="30">30 ngày</option>
                        <option value="7">7 ngày</option>
                        <option value="90">90 ngày</option>
                    </select>
                </div>
            </div>
            <div style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Monthly/Yearly Analytics -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold">Phân tích theo thời gian</h3>
            <div class="flex space-x-2">
                <select id="analyticsPeriod" class="text-sm border border-gray-300 rounded px-3 py-1">
                    <option value="month">Theo tháng</option>
                    <option value="year">Theo năm</option>
                </select>
                <select id="analyticsYear" class="text-sm border border-gray-300 rounded px-3 py-1">
                    <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                    <option value="{{ date('Y') - 1 }}">{{ date('Y') - 1 }}</option>
                    <option value="{{ date('Y') - 2 }}">{{ date('Y') - 2 }}</option>
                </select>
            </div>
        </div>
        <div style="height: 400px;">
            <canvas id="analyticsChart"></canvas>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white rounded-xl border border-gray-200 p-6">
        <h3 class="text-lg font-semibold mb-4">Đơn hàng gần đây</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead>
                    <tr class="text-left text-sm text-gray-500">
                        <th class="py-2 pr-4">Mã đơn</th>
                        <th class="py-2 pr-4">Khách hàng</th>
                        <th class="py-2 pr-4">Tổng tiền</th>
                        <th class="py-2 pr-4">Trạng thái</th>
                        <th class="py-2 pr-4">Ngày đặt</th>
                    </tr>
                </thead>
                <tbody class="text-sm text-gray-700">
                    @forelse(($recentOrders ?? []) as $order)
                        <tr class="border-b">
                            <td class="py-2 pr-4">#{{ $order->id }}</td>
                            <td class="py-2 pr-4">{{ $order->user->full_name }}</td>
                            <td class="py-2 pr-4 font-semibold text-green-600">{{ number_format($order->total_amount, 0, ',', '.') }} VND</td>
                            <td class="py-2 pr-4">{{ ucfirst($order->status) }}</td>
                            <td class="py-2 pr-4">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="py-4 text-center text-gray-500">Chưa có đơn hàng</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initial data from server
    const ordersData = @json($ordersByDay);
    const revenueData = @json($revenueByDay);

    // Chart.js configuration
    const chartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        aspectRatio: 2,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: '#f3f4f6'
                }
            },
            x: {
                grid: {
                    color: '#f3f4f6'
                }
            }
        }
    };

    // Orders Chart
    const ordersCtx = document.getElementById('ordersChart').getContext('2d');
    const ordersChart = new Chart(ordersCtx, {
        type: 'line',
        data: {
            labels: Object.keys(ordersData),
            datasets: [{
                label: 'Đơn hàng',
                data: Object.values(ordersData),
                borderColor: '#3b82f6',
                backgroundColor: 'rgba(59, 130, 246, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: chartOptions
    });

    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    const revenueChart = new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(revenueData),
            datasets: [{
                label: 'Doanh thu (VND)',
                data: Object.values(revenueData),
                backgroundColor: 'rgba(34, 197, 94, 0.8)',
                borderColor: '#22c55e',
                borderWidth: 1
            }]
        },
        options: {
            ...chartOptions,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return 'Doanh thu: ' + new Intl.NumberFormat('vi-VN').format(context.parsed.y) + ' VND';
                        }
                    }
                }
            }
        }
    });

    // Analytics Chart (Monthly/Yearly)
    const analyticsCtx = document.getElementById('analyticsChart').getContext('2d');
    const analyticsChart = new Chart(analyticsCtx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Doanh thu',
                data: [],
                backgroundColor: 'rgba(59, 130, 246, 0.8)',
                borderColor: '#3b82f6',
                borderWidth: 1
            }, {
                label: 'Lợi nhuận',
                data: [],
                backgroundColor: 'rgba(168, 85, 247, 0.8)',
                borderColor: '#a855f7',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            aspectRatio: 2,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + ' VND';
                        }
                    }
                },
                x: {
                    grid: {
                        color: '#f3f4f6'
                    }
                }
            }
        }
    });

    // Load analytics data
    function loadAnalyticsData() {
        const period = document.getElementById('analyticsPeriod').value;
        const year = document.getElementById('analyticsYear').value;

        fetch(`/admin/api/analytics?period=${period}&year=${year}`)
            .then(response => response.json())
            .then(data => {
                analyticsChart.data.labels = data.labels;
                analyticsChart.data.datasets[0].data = data.revenue;
                analyticsChart.data.datasets[1].data = data.profit;
                analyticsChart.update();
            })
            .catch(error => console.error('Error loading analytics:', error));
    }

    // Event listeners
    document.getElementById('analyticsPeriod').addEventListener('change', loadAnalyticsData);
    document.getElementById('analyticsYear').addEventListener('change', loadAnalyticsData);

    // Load initial analytics data
    loadAnalyticsData();

    // Period change handlers for orders and revenue charts
    document.getElementById('ordersPeriod').addEventListener('change', function() {
        const days = this.value;
        fetch(`/admin/api/orders-chart?days=${days}`)
            .then(response => response.json())
            .then(data => {
                ordersChart.data.labels = data.labels;
                ordersChart.data.datasets[0].data = data.data;
                ordersChart.update();
            });
    });

    document.getElementById('revenuePeriod').addEventListener('change', function() {
        const days = this.value;
        fetch(`/admin/api/revenue-chart?days=${days}`)
            .then(response => response.json())
            .then(data => {
                revenueChart.data.labels = data.labels;
                revenueChart.data.datasets[0].data = data.data;
                revenueChart.update();
            });
    });
});
</script>
@endpush
