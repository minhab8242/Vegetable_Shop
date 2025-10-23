<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            ReviewSeeder::class,
            OrderSeeder::class,
        ]);

        User::factory()->create([
            'full_name' => 'Admin User',
            'email' => 'admin@vegetable-store.com',
            'role' => 'admin',
        ]);

        User::factory()->create([
            'full_name' => 'Test User',
            'email' => 'user@example.com',
            'role' => 'user',
        ]);
    }
}
