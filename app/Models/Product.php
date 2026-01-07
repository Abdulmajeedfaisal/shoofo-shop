<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'merchant_id',
        'merchant_category_id',
        'name',
        'name_ar',
        'slug',
        'description',
        'description_ar',
        'price',
        'sale_price',
        'quantity',
        'sku',
        'is_active',
        'is_featured',
        'featured_order',
        'views_count',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];

    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }

    public function merchantCategory()
    {
        return $this->belongsTo(MerchantCategory::class);
    }

    public function globalCategory()
    {
        return $this->merchantCategory->globalCategory();
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('featured_order');
    }

    public function getCurrentPrice()
    {
        return $this->sale_price ?? $this->price;
    }

    public function isInStock()
    {
        return $this->quantity > 0;
    }

    public function scopeByGlobalCategory($query, $globalCategoryId)
    {
        return $query->whereHas('merchantCategory', function($q) use ($globalCategoryId) {
            $q->where('global_category_id', $globalCategoryId);
        });
    }
}
