<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Lấy các category
        $rauXanh = Category::where('name', 'Rau xanh')->first();
        $cuQua = Category::where('name', 'Củ quả')->first();
        $traiCay = Category::where('name', 'Trái cây')->first();
        $giaVi = Category::where('name', 'Gia vị')->first();
        $rauThom = Category::where('name', 'Rau thơm')->first();

        $products = [
            // Rau xanh
            [
                'category_id' => $rauXanh->id,
                'name' => 'Rau muống',
                'description' => 'Rau muống tươi ngon, giàu chất xơ và vitamin. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau muống có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, luộc hoặc nấu canh.',
                'price' => 15000,
                'stock_quantity' => 50,
                'image_url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 1250,
                'rating' => 4.8,
                'review_count' => 156
            ],
            [
                'category_id' => $rauXanh->id,
                'name' => 'Rau cải xanh',
                'description' => 'Rau cải xanh tươi ngon, giàu vitamin A, C và K. Được trồng trong nhà kính, đảm bảo chất lượng và độ tươi. Rau cải xanh có vị ngọt nhẹ, giòn ngon, thích hợp cho các món xào, luộc hoặc nấu canh.',
                'price' => 20000,
                'stock_quantity' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da35?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 890,
                'rating' => 4.6,
                'review_count' => 98
            ],
            [
                'category_id' => $rauXanh->id,
                'name' => 'Rau bó xôi',
                'description' => 'Rau bó xôi tươi ngon, giàu sắt và folate. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau bó xôi có vị ngọt tự nhiên, mềm ngon, thích hợp cho các món xào, luộc hoặc nấu canh.',
                'price' => 25000,
                'stock_quantity' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 650,
                'rating' => 4.7,
                'review_count' => 87
            ],

            // Củ quả
            [
                'category_id' => $cuQua->id,
                'name' => 'Cà rốt',
                'description' => 'Cà rốt tươi ngon, giàu beta-carotene và vitamin A. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Cà rốt có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, luộc hoặc nấu canh.',
                'price' => 20000,
                'stock_quantity' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da35?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 2100,
                'rating' => 4.9,
                'review_count' => 234
            ],
            [
                'category_id' => $cuQua->id,
                'name' => 'Khoai tây',
                'description' => 'Khoai tây tươi ngon, giàu tinh bột và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Khoai tây có vị ngọt tự nhiên, mềm ngon, thích hợp cho các món chiên, luộc hoặc nấu canh.',
                'price' => 18000,
                'stock_quantity' => 60,
                'image_url' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 1800,
                'rating' => 4.5,
                'review_count' => 189
            ],
            [
                'category_id' => $cuQua->id,
                'name' => 'Cà chua',
                'description' => 'Cà chua tươi ngon, giàu lycopene và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Cà chua có vị ngọt tự nhiên, mọng nước, thích hợp cho các món salad, nấu canh hoặc làm nước sốt.',
                'price' => 25000,
                'stock_quantity' => 35,
                'image_url' => 'https://images.unsplash.com/photo-1518977676601-b53f82aba655?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 3200,
                'rating' => 4.8,
                'review_count' => 312
            ],

            // Trái cây
            [
                'category_id' => $traiCay->id,
                'name' => 'Táo',
                'description' => 'Táo tươi ngon, giàu vitamin C và chất xơ. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Táo có vị ngọt tự nhiên, giòn ngon, thích hợp để ăn trực tiếp hoặc làm nước ép.',
                'price' => 45000,
                'stock_quantity' => 20,
                'image_url' => 'https://images.unsplash.com/photo-1560806887-1e4cd0b6cbd6?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 980,
                'rating' => 4.7,
                'review_count' => 145
            ],
            [
                'category_id' => $traiCay->id,
                'name' => 'Chuối',
                'description' => 'Chuối tươi ngon, giàu kali và vitamin B6. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Chuối có vị ngọt tự nhiên, mềm ngon, thích hợp để ăn trực tiếp hoặc làm sinh tố.',
                'price' => 30000,
                'stock_quantity' => 45,
                'image_url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 1500,
                'rating' => 4.6,
                'review_count' => 198
            ],

            // Gia vị
            [
                'category_id' => $giaVi->id,
                'name' => 'Ớt chuông',
                'description' => 'Ớt chuông tươi ngon, giàu vitamin C và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Ớt chuông có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, nướng hoặc salad.',
                'price' => 35000,
                'stock_quantity' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 750,
                'rating' => 4.4,
                'review_count' => 67
            ],
            [
                'category_id' => $giaVi->id,
                'name' => 'Hành tây',
                'description' => 'Hành tây tươi ngon, giàu chất chống oxy hóa và vitamin C. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Hành tây có vị ngọt tự nhiên, giòn ngon, thích hợp cho các món xào, nấu canh hoặc salad.',
                'price' => 22000,
                'stock_quantity' => 40,
                'image_url' => 'https://images.unsplash.com/photo-1598170845058-32b9d6a5da35?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 1100,
                'rating' => 4.3,
                'review_count' => 89
            ],

            // Rau thơm
            [
                'category_id' => $rauThom->id,
                'name' => 'Rau mùi',
                'description' => 'Rau mùi tươi ngon, giàu vitamin K và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Rau mùi có mùi thơm đặc trưng, thích hợp để trang trí hoặc làm gia vị cho các món ăn.',
                'price' => 10000,
                'stock_quantity' => 30,
                'image_url' => 'https://images.unsplash.com/photo-1566385101042-1a0aa0c1268c?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 450,
                'rating' => 4.2,
                'review_count' => 45
            ],
            [
                'category_id' => $rauThom->id,
                'name' => 'Húng quế',
                'description' => 'Húng quế tươi ngon, giàu vitamin A và chất chống oxy hóa. Được trồng theo phương pháp hữu cơ, không sử dụng thuốc trừ sâu. Húng quế có mùi thơm đặc trưng, thích hợp để trang trí hoặc làm gia vị cho các món ăn.',
                'price' => 12000,
                'stock_quantity' => 25,
                'image_url' => 'https://images.unsplash.com/photo-1571771894821-ce9b6c11b08e?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80',
                'sales_count' => 380,
                'rating' => 4.1,
                'review_count' => 38
            ]
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
