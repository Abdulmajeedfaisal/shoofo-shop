<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display the specified product.
     */
    public function show($merchantSlug, $productSlug)
    {
        // Find merchant by slug
        $merchant = Merchant::where('slug', $merchantSlug)
                           ->where('status', 'approved')
                           ->firstOrFail();
        
        // Find product by slug and merchant_id
        $product = Product::where('slug', $productSlug)
                         ->where('merchant_id', $merchant->id)
                         ->where('is_active', true)
                         ->with(['images' => function($query) {
                             $query->orderBy('order');
                         }, 'merchantCategory', 'merchant'])
                         ->firstOrFail();
        
        // Increment views count
        $product->increment('views_count');
        
        // Get related products from same category
        $relatedProducts = Product::where('merchant_category_id', $product->merchant_category_id)
                                  ->where('id', '!=', $product->id)
                                  ->where('is_active', true)
                                  ->with(['primaryImage', 'merchant'])
                                  ->limit(4)
                                  ->get();
        
        return view('products.show', compact('product', 'merchant', 'relatedProducts'));
    }
}
