<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\OrderService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService, private OrderService $orderService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xem giỏ hàng');
        }

        $user = Auth::user();
        $cartItems = $this->cartService->getUserCartItems($user);
        $cartTotal = $this->cartService->getCartTotal($user);
        $cartItemsCount = $this->cartService->getCartItemsCount($user);

        return view('cart.index', compact('cartItems', 'cartTotal', 'cartItemsCount'));
    }


    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        $productId = $request->product_id;
        $quantity = $request->quantity;

        if (!Auth::check()) {
            session([
                'pending_cart_item' => [
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'redirect_url' => url()->previous()
                ]
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng',
                'redirect' => route('login')
            ], 401);
        }

        $user = Auth::user();
        $success = $this->cartService->addToCart($user, $productId, $quantity);

        if ($success) {
            $cartItemsCount = $this->cartService->getCartItemsCount($user);

            return response()->json([
                'success' => true,
                'message' => 'Đã thêm sản phẩm vào giỏ hàng',
                'cart_count' => $cartItemsCount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không thể thêm sản phẩm vào giỏ hàng. Có thể sản phẩm đã hết hàng'
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để cập nhật giỏ hàng');
        }

        $request->validate([
            'quantity' => 'required|integer|min:0|max:99'
        ]);

        $user = Auth::user();
        $quantity = $request->quantity;

        $success = $this->cartService->updateCartItemQuantity($user, $id, $quantity);

        if ($success) {
            $cartItem = $user->carts()->find($id);
            $cartTotal = $this->cartService->getCartTotal($user);
            $cartItemsCount = $this->cartService->getCartItemsCount($user);

            return response()->json([
                'success' => true,
                'message' => 'Đã cập nhật giỏ hàng',
                'subtotal' => $cartItem ? $cartItem->subtotal : 0,
                'cart_total' => number_format($cartTotal, 0, ',', '.') . ' VND',
                'cart_count' => $cartItemsCount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không thể cập nhật giỏ hàng'
            ], 400);
        }
    }

    public function remove($id)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xóa sản phẩm khỏi giỏ hàng');
        }

        $user = Auth::user();
        $success = $this->cartService->removeFromCart($user, $id);

        if ($success) {
            $cartTotal = $this->cartService->getCartTotal($user);
            $cartItemsCount = $this->cartService->getCartItemsCount($user);

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng',
                'cart_total' => number_format($cartTotal, 0, ',', '.') . ' VND',
                'cart_count' => $cartItemsCount
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Không thể xóa sản phẩm khỏi giỏ hàng'
            ], 400);
        }
    }

    public function clear()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để xóa giỏ hàng');
        }

        $user = Auth::user();
        $this->cartService->clearCart($user);

        return response()->json([
            'success' => true,
            'message' => 'Đã xóa tất cả sản phẩm khỏi giỏ hàng',
            'cart_count' => 0
        ]);
    }

    public function checkout(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để thanh toán');
        }

        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:carts,id'
        ]);

        $user = Auth::user();
        $selectedItemIds = $request->selected_items;

        $selectedItems = $user->carts()->whereIn('id', $selectedItemIds)->get();

        if ($selectedItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không có sản phẩm nào được chọn để thanh toán'
            ], 400);
        }

        $total = $selectedItems->sum('subtotal');

        session([
            'checkout_items' => $selectedItems->toArray(),
            'checkout_total' => $total
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Đã chuẩn bị đơn hàng để thanh toán',
            'total' => number_format($total, 0, ',', '.') . ' VND',
            'item_count' => $selectedItems->count(),
            'redirect' => route('checkout.index')
        ]);
    }
    
    public function confirm(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Vui lòng đăng nhập để thanh toán'
            ], 401);
        }

        $request->validate([
            'selected_items' => 'required|array',
            'selected_items.*' => 'exists:carts,id'
        ]);

        $user = Auth::user();

        $selectedItemIds = $request->selected_items;
        $cartItems = $user->carts()->with('product')->whereIn('id', $selectedItemIds)->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Không có sản phẩm nào được chọn để thanh toán'
            ], 400);
        }

        try {
            $order = $this->orderService->createFromCartItems($user, $cartItems);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không thể tạo đơn hàng. Vui lòng thử lại sau.'
            ], 500);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tạo đơn hàng thành công',
            'order_id' => $order->id
        ]);
    }
}
