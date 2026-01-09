<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'subtotal',
        'tax',
        'shipping',
        'total',
        'shipping_name',
        'shipping_email',
        'shipping_phone',
        'shipping_address',
        'shipping_city',
        'shipping_country',
        'shipping_postal_code',
        'payment_method',
        'payment_status',
        'notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'tax' => 'decimal:2',
        'shipping' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    /**
     * Get the user that owns this order
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all items in this order
     */
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all merchant orders (sub-orders)
     */
    public function merchantOrders(): HasMany
    {
        return $this->hasMany(MerchantOrder::class);
    }

    /**
     * Generate unique order number
     */
    public static function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'SHF-' . strtoupper(Str::random(8));
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Scope to filter orders by status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Update main order status based on merchant orders
     */
    public function updateStatusFromMerchantOrders(): void
    {
        $merchantOrders = $this->merchantOrders;
        
        if ($merchantOrders->isEmpty()) {
            return;
        }

        // إذا كانت كل الطلبات الفرعية ملغية
        if ($merchantOrders->every(fn ($mo) => $mo->status === 'cancelled')) {
            $this->update(['status' => 'cancelled']);
            return;
        }

        // إذا كانت كل الطلبات الفرعية مسلمة
        if ($merchantOrders->where('status', '!=', 'cancelled')->every(fn ($mo) => $mo->status === 'delivered')) {
            $this->update(['status' => 'delivered']);
            return;
        }

        // إذا كان أي طلب فرعي مشحون
        if ($merchantOrders->contains('status', 'shipped')) {
            $this->update(['status' => 'shipped']);
            return;
        }

        // إذا كان أي طلب فرعي قيد التجهيز
        if ($merchantOrders->contains('status', 'processing')) {
            $this->update(['status' => 'processing']);
            return;
        }

        // إذا كان أي طلب فرعي مؤكد
        if ($merchantOrders->contains('status', 'confirmed')) {
            $this->update(['status' => 'confirmed']);
            return;
        }

        // الافتراضي: قيد الانتظار
        $this->update(['status' => 'pending']);
    }
}
