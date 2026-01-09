<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class Merchant extends Model
{
    protected $fillable = [
        'user_id',
        'store_name',
        'store_name_ar',
        'slug',
        'description',
        'description_ar',
        'logo',
        'phone',
        'address',
        'status',
        'is_featured',
        'approved_at',
        'shipping_type',
        'shipping_cost',
        'free_shipping_threshold',
        'can_manage_shipping',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'is_featured' => 'boolean',
        'shipping_cost' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'can_manage_shipping' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function merchantCategories()
    {
        return $this->hasMany(MerchantCategory::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Get all merchant orders (sub-orders) for this merchant
     */
    public function merchantOrders()
    {
        return $this->hasMany(MerchantOrder::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Get the logo URL.
     * Handles both external URLs and local storage paths.
     */
    protected function logoUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->logo)) {
                    return null;
                }

                // If it's already a full URL, return as-is
                if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
                    return $this->logo;
                }

                // Otherwise, it's a local storage path
                return Storage::url($this->logo);
            }
        );
    }
}
