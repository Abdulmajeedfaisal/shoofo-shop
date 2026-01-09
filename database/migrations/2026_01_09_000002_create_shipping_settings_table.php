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
        // جدول إعدادات الشحن العامة
        Schema::create('shipping_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // إضافة حقول الشحن لجدول التجار
        Schema::table('merchants', function (Blueprint $table) {
            $table->enum('shipping_type', ['free', 'fixed', 'calculated'])->default('free')->after('is_featured');
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('shipping_type');
            $table->decimal('free_shipping_threshold', 10, 2)->nullable()->after('shipping_cost');
        });

        // إضافة حقل الشحن لجدول merchant_orders
        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->decimal('shipping_cost', 10, 2)->default(0)->after('subtotal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('merchant_orders', function (Blueprint $table) {
            $table->dropColumn('shipping_cost');
        });

        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn(['shipping_type', 'shipping_cost', 'free_shipping_threshold']);
        });

        Schema::dropIfExists('shipping_settings');
    }
};
