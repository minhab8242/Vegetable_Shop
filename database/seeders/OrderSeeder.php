<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get users and products
        $users = User::where('role', 'user')->get();
        $products = Product::all();

        if ($users->isEmpty() || $products->isEmpty()) {
            $this->command->info('No users or products found. Skipping order seeding.');
            return;
        }

        // Create some completed orders for testing reviews
        foreach ($users->take(3) as $user) {
            // Create 2-3 orders per user
            $orderCount = rand(2, 3);

            for ($i = 0; $i < $orderCount; $i++) {
                $order = Order::create([
                    'user_id' => $user->id,
                    'status' => 'completed',
                    'total_amount' => 0, // Will be calculated
                ]);

                // Add 2-4 products to each order
                $productCount = rand(2, 4);
                $selectedProducts = $products->random($productCount);
                $totalAmount = 0;

                foreach ($selectedProducts as $product) {
                    $quantity = rand(1, 3);
                    $subtotal = $product->price * $quantity;
                    $totalAmount += $subtotal;

                    OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'product_name' => $product->name,
                        'product_description' => $product->description,
                        'quantity' => $quantity,
                        'price' => $product->price,
                    ]);
                }

                // Update order total amount
                $order->update(['total_amount' => $totalAmount]);
            }
        }

        $this->command->info('Orders created successfully for review testing.');
    }
}
