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
        Schema::create('merchant_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('merchant_id')->constrained()->onDelete('cascade');
            $table->foreignId('global_category_id')->constrained()->onDelete('restrict');
            $table->string('name');
            $table->string('name_ar')->nullable();
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('description_ar')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Unique constraint: merchant can't have duplicate slugs
            $table->unique(['merchant_id', 'slug']);
            
            // Indexes for performance
            $table->index('merchant_id');
            $table->index('global_category_id');
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('merchant_categories');
    }
};
