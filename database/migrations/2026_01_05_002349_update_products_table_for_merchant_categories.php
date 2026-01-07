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
        Schema::table('products', function (Blueprint $table) {
            // Drop old foreign key and column
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
            
            // Add new merchant_category_id column
            $table->foreignId('merchant_category_id')->after('merchant_id')->constrained()->onDelete('cascade');
            
            // Add featured_order column for ordering featured products
            $table->integer('featured_order')->nullable()->after('is_featured');
            
            // Add index for merchant_category_id
            $table->index('merchant_category_id');
            $table->index('is_featured');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Drop new columns and foreign key
            $table->dropForeign(['merchant_category_id']);
            $table->dropColumn(['merchant_category_id', 'featured_order']);
            
            // Restore old category_id column
            $table->foreignId('category_id')->after('merchant_id')->constrained()->onDelete('cascade');
        });
    }
};
