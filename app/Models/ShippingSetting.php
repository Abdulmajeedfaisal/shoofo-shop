<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ShippingSetting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key
     */
    public static function get(string $key, $default = null)
    {
        return Cache::remember("shipping_setting_{$key}", 3600, function () use ($key, $default) {
            $setting = self::where('key', $key)->first();
            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value
     */
    public static function set(string $key, $value): void
    {
        self::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("shipping_setting_{$key}");
    }

    /**
     * Get all settings as array
     */
    public static function getAllSettings(): array
    {
        return Cache::remember('all_shipping_settings', 3600, function () {
            return self::pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear all shipping settings cache
     */
    public static function clearCache(): void
    {
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget("shipping_setting_{$setting->key}");
        }
        Cache::forget('all_shipping_settings');
    }

    // ============ Helper Methods ============

    /**
     * Get global shipping type: free, fixed, threshold, per_merchant
     */
    public static function getShippingType(): string
    {
        return self::get('shipping_type', 'free');
    }

    /**
     * Get fixed shipping cost
     */
    public static function getFixedCost(): float
    {
        return (float) self::get('fixed_shipping_cost', 0);
    }

    /**
     * Get free shipping threshold
     */
    public static function getFreeThreshold(): float
    {
        return (float) self::get('free_shipping_threshold', 0);
    }

    /**
     * Check if specific merchant can manage shipping
     */
    public static function canMerchantManageShipping(?Merchant $merchant): bool
    {
        if (!$merchant) {
            return false;
        }

        $globalType = self::getShippingType();
        
        // إذا كان النوع "حسب التاجر" فكل التجار يمكنهم التحكم
        if ($globalType === 'per_merchant') {
            return true;
        }

        // تحقق من صلاحية التاجر الفردية
        return $merchant->can_manage_shipping ?? false;
    }

    /**
     * Calculate shipping for a merchant order
     */
    public static function calculateShipping(float $subtotal, ?Merchant $merchant = null): float
    {
        $globalType = self::getShippingType();

        // إذا كان التاجر يمكنه تحديد الشحن وله إعدادات خاصة
        if ($merchant && self::canMerchantManageShipping($merchant) && $merchant->shipping_type !== 'free') {
            return self::calculateMerchantShipping($subtotal, $merchant);
        }

        // الإعدادات العامة
        return match($globalType) {
            'free' => 0,
            'fixed' => self::getFixedCost(),
            'threshold' => $subtotal >= self::getFreeThreshold() ? 0 : self::getFixedCost(),
            'per_merchant' => $merchant ? self::calculateMerchantShipping($subtotal, $merchant) : 0,
            default => 0,
        };
    }

    /**
     * Calculate shipping based on merchant settings
     */
    private static function calculateMerchantShipping(float $subtotal, Merchant $merchant): float
    {
        return match($merchant->shipping_type) {
            'free' => 0,
            'fixed' => $merchant->shipping_cost,
            'calculated' => $merchant->free_shipping_threshold && $subtotal >= $merchant->free_shipping_threshold 
                ? 0 
                : $merchant->shipping_cost,
            default => 0,
        };
    }
}
