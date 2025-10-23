<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->unsigned(); // 1-5 stars
            $table->text('comment')->nullable();
            $table->string('title')->nullable(); // Review title
            $table->boolean('is_verified_purchase')->default(false); // Verified purchase
            $table->boolean('is_helpful')->default(false); // Helpful review
            $table->integer('helpful_count')->default(0); // Number of helpful votes
            $table->json('images')->nullable(); // Review images
            $table->timestamps();

            // Ensure one review per user per product
            $table->unique(['user_id', 'product_id']);

            // Indexes for better performance
            $table->index(['product_id', 'rating']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
