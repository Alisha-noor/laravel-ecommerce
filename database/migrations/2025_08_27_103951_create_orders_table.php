<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            // If orders already exists, optionally ensure missing columns exist.
            Schema::table('orders', function (Blueprint $table) {
                if (!Schema::hasColumn('orders', 'name'))            $table->string('name')->nullable()->after('id');
                if (!Schema::hasColumn('orders', 'email'))           $table->string('email')->nullable()->after('name');
                if (!Schema::hasColumn('orders', 'phone'))           $table->string('phone')->nullable()->after('email');
                if (!Schema::hasColumn('orders', 'address'))         $table->text('address')->nullable()->after('phone');
                if (!Schema::hasColumn('orders', 'city'))            $table->string('city')->nullable()->after('address');
                if (!Schema::hasColumn('orders', 'state'))           $table->string('state')->nullable()->after('city');
                if (!Schema::hasColumn('orders', 'country'))         $table->string('country')->nullable()->after('state');
                if (!Schema::hasColumn('orders', 'zip'))             $table->string('zip')->nullable()->after('country');
                if (!Schema::hasColumn('orders', 'status'))          $table->enum('status', ['pending','completed','delivered','canceled'])->default('pending')->after('zip');
                if (!Schema::hasColumn('orders', 'total'))           $table->decimal('total', 12, 2)->default(0)->after('status');
                if (!Schema::hasColumn('orders', 'tracking_number')) $table->string('tracking_number')->nullable()->after('total');
                if (!Schema::hasColumn('orders', 'notes'))           $table->text('notes')->nullable()->after('tracking_number');
                if (!Schema::hasColumn('orders', 'delivered_date'))  $table->dateTime('delivered_date')->nullable()->after('notes');
                if (!Schema::hasColumn('orders', 'created_at'))      $table->timestamps();
                // helpful indexes
                // if needed you can add: $table->index(['status', 'created_at']); $table->index(['name','phone']);
            });
            return;
        }

        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip')->nullable();

            $table->enum('status', ['pending','completed','delivered','canceled'])->default('pending');
            $table->decimal('total', 12, 2)->default(0);
            $table->string('tracking_number')->nullable();
            $table->text('notes')->nullable();
            $table->dateTime('delivered_date')->nullable();

            $table->timestamps();

            $table->index(['status','created_at']);
            $table->index(['name','phone']);
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::dropIfExists('orders');
        }
    }
};
