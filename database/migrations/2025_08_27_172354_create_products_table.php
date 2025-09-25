<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Prevent duplicate creation if the table already exists
        if (Schema::hasTable('products')) {
            return;
        }

        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // Core product info
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description')->nullable();
            $table->text('description');

            // Pricing
            $table->decimal('regular_price', 10, 2);
            $table->decimal('sale_price', 10, 2)->nullable();

            // Stock & inventory
            $table->string('SKU')->unique();
            $table->enum('stock_status', ['instock', 'outofstock'])->default('instock');
            $table->boolean('featured')->default(false);
            $table->unsignedInteger('quantity')->default(10);

            // Images
            $table->string('image')->nullable();
            $table->text('images')->nullable(); // for gallery (comma separated)

            // Relationships (FKs)
            $table->foreignId('category_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('cascade');

            // Metadata
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};