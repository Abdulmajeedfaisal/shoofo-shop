<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];

    /**
     * Get the user that owns this cart
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this cart
     */
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Calculate total amount of all items in cart
     */
    public function getTotalAmount(): float
    {
        return $this->items->sum(function ($item) {
            return $item->getSubtotal();
        });
    }

    /**
     * Get total number of items in cart
     */
    public function getItemsCount(): int
    {
        return $this->items->sum('quantity');
    }
}
