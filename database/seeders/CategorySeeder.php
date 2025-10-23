<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Rau xanh',
                'description' => 'Các loại rau xanh tươi ngon, giàu dinh dưỡng'
            ],
            [
                'name' => 'Củ quả',
                'description' => 'Các loại củ quả đa dạng, tươi ngon'
            ],
            [
                'name' => 'Trái cây',
                'description' => 'Trái cây tươi ngon, giàu vitamin'
            ],
            [
                'name' => 'Gia vị',
                'description' => 'Các loại gia vị tự nhiên cho món ăn thêm ngon'
            ],
            [
                'name' => 'Rau thơm',
                'description' => 'Các loại rau thơm tươi ngon cho món ăn'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
