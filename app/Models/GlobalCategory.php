<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GlobalCategory extends Model
{
    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'icon',
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
}
