<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        $users = User::where('role', 'user')->get();

        if ($users->isEmpty()) {
            // Create some test users if none exist
            $users = collect([
                User::create([
                    'full_name' => 'Nguyễn Văn A',
                    'email' => 'user1@example.com',
                    'password' => bcrypt('password'),
                    'phone' => '0123456789',
                    'address' => '123 Đường ABC, Quận 1, TP.HCM',
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]),
                User::create([
                    'full_name' => 'Trần Thị B',
                    'email' => 'user2@example.com',
                    'password' => bcrypt('password'),
                    'phone' => '0987654321',
                    'address' => '456 Đường XYZ, Quận 2, TP.HCM',
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]),
                User::create([
                    'full_name' => 'Lê Văn C',
                    'email' => 'user3@example.com',
                    'password' => bcrypt('password'),
                    'phone' => '0555666777',
                    'address' => '789 Đường DEF, Quận 3, TP.HCM',
                    'role' => 'user',
                    'email_verified_at' => now(),
                ]),
            ]);
        }

        $reviewTemplates = [
            [
                'rating' => 5,
                'title' => 'Sản phẩm tuyệt vời!',
                'comment' => 'Chất lượng rất tốt, tươi ngon. Sẽ mua lại lần sau.',
                'is_verified_purchase' => true,
                'helpful_count' => 12
            ],
            [
                'rating' => 4,
                'title' => 'Khá hài lòng',
                'comment' => 'Sản phẩm tươi, giá cả hợp lý. Giao hàng nhanh.',
                'is_verified_purchase' => true,
                'helpful_count' => 8
            ],
            [
                'rating' => 5,
                'title' => 'Xuất sắc!',
                'comment' => 'Rất tươi ngon, đóng gói cẩn thận. Khuyến nghị mọi người nên thử.',
                'is_verified_purchase' => true,
                'helpful_count' => 15
            ],
            [
                'rating' => 3,
                'title' => 'Bình thường',
                'comment' => 'Chất lượng ổn, không có gì đặc biệt.',
                'is_verified_purchase' => false,
                'helpful_count' => 3
            ],
            [
                'rating' => 4,
                'title' => 'Tốt',
                'comment' => 'Sản phẩm tươi, đúng như mô tả. Giao hàng đúng hẹn.',
                'is_verified_purchase' => true,
                'helpful_count' => 6
            ],
            [
                'rating' => 5,
                'title' => 'Hoàn hảo!',
                'comment' => 'Chất lượng vượt mong đợi. Sẽ là khách hàng thường xuyên.',
                'is_verified_purchase' => true,
                'helpful_count' => 20
            ],
            [
                'rating' => 2,
                'title' => 'Không như mong đợi',
                'comment' => 'Sản phẩm không tươi như quảng cáo.',
                'is_verified_purchase' => false,
                'helpful_count' => 1
            ],
            [
                'rating' => 4,
                'title' => 'Hài lòng',
                'comment' => 'Chất lượng tốt, giá cả phải chăng.',
                'is_verified_purchase' => true,
                'helpful_count' => 7
            ],
            [
                'rating' => 5,
                'title' => 'Tuyệt vời!',
                'comment' => 'Rất tươi ngon, đóng gói đẹp. Cảm ơn shop!',
                'is_verified_purchase' => true,
                'helpful_count' => 18
            ],
            [
                'rating' => 3,
                'title' => 'Ổn',
                'comment' => 'Chất lượng bình thường, không có gì nổi bật.',
                'is_verified_purchase' => false,
                'helpful_count' => 2
            ]
        ];

        foreach ($products as $product) {
            // Create 3-8 reviews per product
            $reviewCount = rand(3, 8);
            $usedUsers = collect();

            for ($i = 0; $i < $reviewCount; $i++) {
                // Get a user that hasn't reviewed this product yet
                $availableUsers = $users->diff($usedUsers);
                if ($availableUsers->isEmpty()) {
                    break; // No more users available
                }

                $user = $availableUsers->random();
                $usedUsers->push($user);
                $template = $reviewTemplates[array_rand($reviewTemplates)];

                // Check if review already exists
                $existingReview = Review::where('user_id', $user->id)
                    ->where('product_id', $product->id)
                    ->first();

                if (!$existingReview) {
                    Review::create([
                        'user_id' => $user->id,
                        'product_id' => $product->id,
                        'rating' => $template['rating'],
                        'title' => $template['title'],
                        'comment' => $template['comment'],
                        'is_verified_purchase' => $template['is_verified_purchase'],
                        'helpful_count' => $template['helpful_count'],
                        'created_at' => now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }

        // Update product ratings
        foreach ($products as $product) {
            $averageRating = $product->reviews()->avg('rating');
            $reviewCount = $product->reviews()->count();

            $product->update([
                'rating' => round($averageRating, 2),
                'review_count' => $reviewCount
            ]);
        }
    }
}
