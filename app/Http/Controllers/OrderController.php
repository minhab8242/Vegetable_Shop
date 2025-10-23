<?php

namespace App\Http\Controllers;

use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function __construct(private OrderService $orderService)
    {
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem đơn hàng');
        }

        $orders = $this->orderService->getUserOrders(Auth::user());
        return view('orders.index', compact('orders'));
    }

    public function show($orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem đơn hàng');
        }

        $order = Auth::user()
            ->orders()
            ->with('orderDetails')
            ->findOrFail($orderId);

        return view('orders.show', compact('order'));
    }

    public function receive($orderId)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thực hiện hành động này');
        }

        $order = Auth::user()->orders()->findOrFail($orderId);

        // Only allow receiving if status is shipping
        if ($order->status !== 'shipping') {
            return redirect()->route('orders.index')->with('error', 'Không thể xác nhận nhận hàng cho đơn hàng này.');
        }

        // Update status to completed
        $order->update(['status' => 'completed']);

        return redirect()->route('orders.index')->with('success', 'Cảm ơn bạn đã xác nhận nhận hàng!');
    }
}


