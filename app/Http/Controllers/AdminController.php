<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class AdminController extends Controller
{
    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ], [
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất :min ký tự.',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => 'Bạn không có quyền truy cập admin.'])->withInput();
            }

            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors(['email' => 'Email hoặc mật khẩu không đúng.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }

    public function dashboard()
    {
        // Basic stats
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'orders' => Order::count(),
            'customers' => User::where('role', 'user')->count(),
        ];

        // Revenue and profit calculations
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount');
        $totalProfit = Order::where('status', '!=', 'cancelled')
            ->with('orderDetails.product')
            ->get()
            ->sum(function ($order) {
                return $order->orderDetails->sum(function ($detail) {
                    if ($detail->product && $detail->product->cost_price) {
                        return ($detail->price - $detail->product->cost_price) * $detail->quantity;
                    }
                    return 0;
                });
            });

        // Orders by day (last 30 days)
        $ordersByDay = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('count', 'date');

        // Revenue by day (last 30 days)
        $revenueByDay = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('revenue', 'date');

        $recentOrders = Order::with('user')->latest()->limit(5)->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentOrders',
            'totalRevenue',
            'totalProfit',
            'ordersByDay',
            'revenueByDay'
        ));
    }

    public function products()
    {
        return view('admin.products');
    }

    public function getAnalyticsData(Request $request)
    {
        $period = $request->get('period', 'month');
        $year = $request->get('year', date('Y'));

        if ($period === 'month') {
            $data = Order::selectRaw('MONTH(created_at) as month, SUM(total_amount) as revenue')
                ->whereYear('created_at', $year)
                ->where('status', '!=', 'cancelled')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $profitData = Order::whereYear('created_at', $year)
                ->where('status', '!=', 'cancelled')
                ->with('orderDetails.product')
                ->get()
                ->groupBy(function($order) {
                    return $order->created_at->format('n');
                })
                ->map(function($orders, $month) {
                    return $orders->sum(function($order) {
                        return $order->orderDetails->sum(function($detail) {
                            if ($detail->product && $detail->product->cost_price) {
                                return ($detail->price - $detail->product->cost_price) * $detail->quantity;
                            }
                            return 0;
                        });
                    });
                });

            $labels = ['T1', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7', 'T8', 'T9', 'T10', 'T11', 'T12'];
            $revenue = array_fill(0, 12, 0);
            $profit = array_fill(0, 12, 0);

            foreach ($data as $item) {
                $revenue[$item->month - 1] = $item->revenue;
            }

            foreach ($profitData as $month => $profitAmount) {
                $profit[$month - 1] = $profitAmount;
            }
        } else {
            $data = Order::selectRaw('YEAR(created_at) as year, SUM(total_amount) as revenue')
                ->where('status', '!=', 'cancelled')
                ->groupBy('year')
                ->orderBy('year')
                ->get();

            $profitData = Order::where('status', '!=', 'cancelled')
                ->with('orderDetails.product')
                ->get()
                ->groupBy(function($order) {
                    return $order->created_at->format('Y');
                })
                ->map(function($orders) {
                    return $orders->sum(function($order) {
                        return $order->orderDetails->sum(function($detail) {
                            if ($detail->product && $detail->product->cost_price) {
                                return ($detail->price - $detail->product->cost_price) * $detail->quantity;
                            }
                            return 0;
                        });
                    });
                });

            $labels = $data->pluck('year')->toArray();
            $revenue = $data->pluck('revenue')->toArray();
            $profit = $profitData->values()->toArray();
        }

        return response()->json([
            'labels' => $labels,
            'revenue' => $revenue,
            'profit' => $profit
        ]);
    }

    public function getOrdersChartData(Request $request)
    {
        $days = $request->get('days', 30);

        $data = Order::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $counts = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            $counts[] = $data->where('date', $date)->first()->count ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $counts
        ]);
    }

    public function getRevenueChartData(Request $request)
    {
        $days = $request->get('days', 30);

        $data = Order::selectRaw('DATE(created_at) as date, SUM(total_amount) as revenue')
            ->where('status', '!=', 'cancelled')
            ->where('created_at', '>=', now()->subDays($days))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $labels = [];
        $revenues = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $labels[] = now()->subDays($i)->format('d/m');
            $revenues[] = $data->where('date', $date)->first()->revenue ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $revenues
        ]);
    }
}
