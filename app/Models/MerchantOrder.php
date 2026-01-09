<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MerchantOrder extends Model
{
    protected $fillable = [
        'order_id',
        'merchant_id',
        'sub_order_number',
        'status',
        'subtotal',
        'shipping_cost',
        'merchant_notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
    ];

    /**
     * Get total with shipping
     */
    public function getTotalAttribute(): float
    {
        return (float) $this->subtotal + (float) $this->shipping_cost;
    }

    /**
     * Get the parent order
     */
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Get the merchant
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get all items in this merchant order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate sub-order number
     */
    public static function generateSubOrderNumber(string $orderNumber, int $index): string
    {
        return $orderNumber . '-' . $index;
    }

    /**
     * Get items count
     */
    public function getItemsCountAttribute(): int
    {
        return $this->items()->count();
    }

    /**
     * Get total quantity
     */
    public function getTotalQuantityAttribute(): int
    {
        return $this->items()->sum('quantity');
    }

    /**
     * Check if can be confirmed
     */
    public function canBeConfirmed(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if can be processed
     */
    public function canBeProcessed(): bool
    {
        return $this->status === 'confirmed';
    }

    /**
     * Check if can be shipped
     */
    public function canBeShipped(): bool
    {
        return $this->status === 'processing';
    }

    /**
     * Check if can be delivered
     */
    public function canBeDelivered(): bool
    {
        return $this->status === 'shipped';
    }

    /**
     * Check if can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return !in_array($this->status, ['delivered', 'cancelled', 'shipped']);
    }

    /**
     * Get next status
     */
    public function getNextStatus(): ?string
    {
        return match($this->status) {
            'pending' => 'confirmed',
            'confirmed' => 'processing',
            'processing' => 'shipped',
            'shipped' => 'delivered',
            default => null,
        };
    }

    /**
     * Get status label in Arabic
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'قيد الانتظار',
            'confirmed' => 'مؤكد',
            'processing' => 'قيد التجهيز',
            'shipped' => 'تم الشحن',
            'delivered' => 'تم التسليم',
            'cancelled' => 'ملغي',
            default => $this->status,
        };
    }
}
