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
        // إنشاء جدول الطلبات الفرعية للتجار
        Schema::create('merchant_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('merchant_id')->constrained()->onDelete('restrict');
            $table->string('sub_order_number', 60)->unique();
            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->text('merchant_notes')->nullable();
            $table->timestamps();
            
            // Indexes
            $table->index(['order_id', 'merchant_id']);
            $table->index('status');
            $table->index('sub_order_number');
        });

        // إضافة merchant_order_id لجدول order_items
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('merchant_order_id')->nullable()->after('merchant_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['merchant_order_id']);
            $table->dropColumn('merchant_order_id');
        });

        Schema::dropIfExists('merchant_orders');
    }
};
