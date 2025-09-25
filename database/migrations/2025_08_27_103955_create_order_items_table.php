<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Ensure orders table exists first
        if (!Schema::hasTable('orders')) {
            throw new RuntimeException("orders table must be created before order_items.");
        }

        if (Schema::hasTable('order_items')) {
            Schema::table('order_items', function (Blueprint $table) {
                if (!Schema::hasColumn('order_items', 'order_id')) $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
                if (!Schema::hasColumn('order_items', 'sku'))      $table->string('sku')->nullable();
                if (!Schema::hasColumn('order_items', 'name'))     $table->string('name');
                if (!Schema::hasColumn('order_items', 'qty'))      $table->unsignedInteger('qty');
                if (!Schema::hasColumn('order_items', 'price'))    $table->decimal('price', 12, 2);
                if (!Schema::hasColumn('order_items', 'total'))    $table->decimal('total', 12, 2);
                if (!Schema::hasColumn('order_items', 'created_at')) $table->timestamps();
            });
            return;
        }

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('sku')->nullable();
            $table->string('name');
            $table->unsignedInteger('qty');
            $table->decimal('price', 12, 2);
            $table->decimal('total', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('order_items')) {
            Schema::dropIfExists('order_items');
        }
    }
};
