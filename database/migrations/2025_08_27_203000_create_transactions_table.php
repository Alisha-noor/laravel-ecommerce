<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            throw new \RuntimeException("orders table must be created before transactions.");
        }

        if (Schema::hasTable('transactions')) {
            Schema::table('transactions', function (Blueprint $table) {
                if (!Schema::hasColumn('transactions', 'user_id')) {
                    $table->foreignId('user_id')->after('id')->constrained('users')->cascadeOnDelete();
                }
                if (!Schema::hasColumn('transactions', 'order_id')) {
                    $table->foreignId('order_id')->after('user_id')->constrained('orders')->cascadeOnDelete();
                }
                if (!Schema::hasColumn('transactions', 'mode'))   $table->string('mode', 20)->nullable();
                if (!Schema::hasColumn('transactions', 'status')) $table->string('status', 30)->default('pending');
                if (!Schema::hasColumn('transactions', 'amount')) $table->decimal('amount', 12, 2)->default(0);
                if (!Schema::hasColumn('transactions', 'code'))   $table->string('code')->nullable();
                if (!Schema::hasColumn('transactions', 'notes'))  $table->text('notes')->nullable();
                if (!Schema::hasColumn('transactions', 'created_at')) $table->timestamps();
            });
            return;
        }

        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->string('mode', 20)->nullable();         // matches controller
            $table->string('status', 30)->default('pending');
            $table->decimal('amount', 12, 2)->default(0);
            $table->string('code')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
