<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchantCategory extends Model
{
    protected $fillable = [
        'merchant_id',
        'global_category_id',
        'name',
        'name_ar',
        'slug',
        'description',
        'description_ar',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get the merchant that owns this category
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the global category this merchant category is linked to
     */
    public function globalCategory(): BelongsTo
    {
        return $this->belongsTo(GlobalCategory::class);
    }

    /**
     * Get all products in this merchant category
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get only featured products in this category
     */
    public function featuredProducts(): HasMany
    {
        return $this->products()
            ->where('is_featured', true)
            ->orderBy('featured_order');
    }

    /**
     * Scope to get only active categories ordered by order field
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
