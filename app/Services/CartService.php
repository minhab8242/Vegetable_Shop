<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CartService
{

    public function getUserCartItems(User $user): Collection
    {
        return Cart::with('product.category')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
    }


    public function addToCart(User $user, int $productId, int $quantity = 1): bool
    {
        $product = Product::find($productId);

        if (!$product || $product->stock_quantity < $quantity) {
            return false;
        }

        $existingCartItem = Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if ($existingCartItem) {
            $newQuantity = $existingCartItem->quantity + $quantity;
            if ($newQuantity > $product->stock_quantity) {
                return false;
            }
            $existingCartItem->quantity = $newQuantity;
            $existingCartItem->save();
        } else {
            Cart::create([
                'user_id' => $user->id,
                'product_id' => $productId,
                'quantity' => $quantity,
            ]);
        }

        return true;
    }

    public function updateCartItemQuantity(User $user, int $cartItemId, int $quantity): bool
    {
        $cartItem = Cart::where('user_id', $user->id)
            ->where('id', $cartItemId)
            ->first();

        if (!$cartItem) {
            return false;
        }

        if ($quantity <= 0) {
            return $this->removeFromCart($user, $cartItemId);
        }

        if ($quantity > $cartItem->product->stock_quantity) {
            return false;
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

        return true;
    }

    public function removeFromCart(User $user, int $cartItemId): bool
    {
        $cartItem = Cart::where('user_id', $user->id)
            ->where('id', $cartItemId)
            ->first();

        if (!$cartItem) {
            return false;
        }

        $cartItem->delete();
        return true;
    }


    public function clearCart(User $user): bool
    {
        Cart::where('user_id', $user->id)->delete();
        return true;
    }


    public function getCartTotal(User $user): float
    {
        $cartItems = $this->getUserCartItems($user);

        return $cartItems->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }


    public function getCartItemsCount(User $user): int
    {
        return Cart::where('user_id', $user->id)->sum('quantity');
    }


    public function isProductInCart(User $user, int $productId): bool
    {
        return Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->exists();
    }


    public function getCartItemByProduct(User $user, int $productId): ?Cart
    {
        return Cart::where('user_id', $user->id)
            ->where('product_id', $productId)
            ->first();
    }


    public function validateCartStock(User $user): array
    {
        $cartItems = $this->getUserCartItems($user);
        $errors = [];

        foreach ($cartItems as $item) {
            if ($item->quantity > $item->product->stock_quantity) {
                $errors[] = "Sản phẩm '{$item->product->name}' chỉ còn {$item->product->stock_quantity} sản phẩm trong kho.";
            }
        }

        return $errors;
    }
}

