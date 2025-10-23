<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;

class AdminOrderService
{
    public function getAllOrders($perPage = 10, $filters = [])
    {
        $query = Order::with(['user', 'orderDetails']);

        if (!empty($filters['search'])) {
            $query->whereHas('user', function ($q) use ($filters) {
                $q->where('full_name', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function getOrderById($id)
    {
        return Order::with(['user', 'orderDetails'])->findOrFail($id);
    }

    public function updateOrderStatus(Order $order, $status)
    {
        return $order->update(['status' => $status]);
    }

    public function getOrderStatuses()
    {
        return [
            'pending' => 'Chờ xử lý',
            'confirmed' => 'Đã xác nhận',
            'shipping' => 'Đang giao hàng',
            'completed' => 'Hoàn thành',
            'cancelled' => 'Đã hủy',
        ];
    }

    public function getOrderStatusColor($status)
    {
        return match($status) {
            'pending' => 'yellow',
            'confirmed' => 'blue',
            'shipping' => 'purple',
            'completed' => 'green',
            'cancelled' => 'red',
            default => 'gray'
        };
    }

    public function getOrderStats()
    {
        return [
            'total' => Order::count(),
            'pending' => Order::where('status', 'pending')->count(),
            'confirmed' => Order::where('status', 'confirmed')->count(),
            'shipping' => Order::where('status', 'shipping')->count(),
            'completed' => Order::where('status', 'completed')->count(),
            'cancelled' => Order::where('status', 'cancelled')->count(),
        ];
    }
}
