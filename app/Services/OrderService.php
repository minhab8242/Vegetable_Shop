<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function getUserOrders(User $user)
    {
        return $user->orders()
            ->with('orderDetails')
            ->latest()
            ->get();
    }

    public function createFromCartItems(User $user, Collection $cartItems): Order
    {
        return DB::transaction(function () use ($user, $cartItems) {
            $totalAmount = $cartItems->sum(fn ($item) => $item->subtotal);

            $order = Order::create([
                'user_id' => $user->id,
                'total_amount' => $totalAmount,
                'status' => 'pending',
            ]);

            foreach ($cartItems as $item) {
                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'product_description' => $item->product->description,
                    'price' => $item->product->price,
                    'quantity' => $item->quantity,
                ]);
            }

            $user->carts()->whereIn('id', $cartItems->pluck('id'))->delete();

            return $order;
        });
    }
}


