<?php

namespace App\Http\Controllers;

use App\Services\AdminOrderService;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    protected $orderService;

    public function __construct(AdminOrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index(Request $request)
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'date_from' => $request->get('date_from'),
            'date_to' => $request->get('date_to'),
        ];

        $orders = $this->orderService->getAllOrders(10, $filters);
        $statuses = $this->orderService->getOrderStatuses();
        $stats = $this->orderService->getOrderStats();

        return view('admin.orders.index', compact('orders', 'statuses', 'stats', 'filters'));
    }

    public function show($id)
    {
        $order = $this->orderService->getOrderById($id);
        $statuses = $this->orderService->getOrderStatuses();

        return view('admin.orders.show', compact('order', 'statuses'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,shipping,completed,cancelled',
        ], [
            'status.required' => 'Vui lòng chọn trạng thái.',
            'status.in' => 'Trạng thái không hợp lệ.',
        ]);

        $order = $this->orderService->getOrderById($id);
        $this->orderService->updateOrderStatus($order, $request->status);

        return redirect()->route('admin.orders.show', $id)->with('success', 'Cập nhật trạng thái đơn hàng thành công!');
    }
}

