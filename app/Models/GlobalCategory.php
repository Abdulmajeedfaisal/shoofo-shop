<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Storage;

class GlobalCategory extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'icon',
        'image',
        'description',
        'description_ar',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all merchant categories linked to this global category
     */
    public function merchantCategories(): HasMany
    {
        return $this->hasMany(MerchantCategory::class);
    }

    /**
     * Scope to get only active categories ordered by order field
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }

    /**
     * Get the image URL.
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (empty($this->image)) {
                    return null;
                }

                // If it's already a full URL, return as-is
                if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
                    return $this->image;
                }

                // Otherwise, it's a local storage path
                return Storage::url($this->image);
            }
        );
    }
}
