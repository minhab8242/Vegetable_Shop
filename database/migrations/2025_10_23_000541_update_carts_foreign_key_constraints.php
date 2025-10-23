<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to handle foreign key constraints for carts table
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Drop existing foreign key constraints if they exist
        DB::statement('ALTER TABLE carts DROP FOREIGN KEY IF EXISTS carts_product_id_foreign');
        DB::statement('ALTER TABLE carts DROP FOREIGN KEY IF EXISTS carts_user_id_foreign');

        // Make product_id nullable
        DB::statement('ALTER TABLE carts MODIFY COLUMN product_id BIGINT UNSIGNED NULL');

        // Recreate foreign key constraints with ON DELETE SET NULL
        DB::statement('ALTER TABLE carts ADD CONSTRAINT carts_product_id_foreign FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE SET NULL');
        DB::statement('ALTER TABLE carts ADD CONSTRAINT carts_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Use raw SQL to handle foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Drop the new foreign key constraints
        DB::statement('ALTER TABLE carts DROP FOREIGN KEY IF EXISTS carts_product_id_foreign');
        DB::statement('ALTER TABLE carts DROP FOREIGN KEY IF EXISTS carts_user_id_foreign');

        // Make product_id not nullable again
        DB::statement('ALTER TABLE carts MODIFY COLUMN product_id BIGINT UNSIGNED NOT NULL');

        // Recreate original foreign key constraints
        DB::statement('ALTER TABLE carts ADD CONSTRAINT carts_product_id_foreign FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT');
        DB::statement('ALTER TABLE carts ADD CONSTRAINT carts_user_id_foreign FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT');

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
};
