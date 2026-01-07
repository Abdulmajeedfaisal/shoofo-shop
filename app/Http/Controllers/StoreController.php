<?php

namespace App\Http\Controllers;

use App\Models\Merchant;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    /**
     * Display a listing of approved stores.
     */
    public function index()
    {
        $stores = Merchant::where('status', 'approved')
                         ->with('user')
                         ->paginate(12);
        
        return view('stores.index', compact('stores'));
    }
    
    /**
     * Display the specified store with entrance animation.
     */
    public function show($slug)
    {
        $store = Merchant::where('slug', $slug)
                        ->where('status', 'approved')
                        ->with(['merchantCategories' => function($query) {
                            $query->where('is_active', true)->orderBy('order');
                        }])
                        ->firstOrFail();
        
        $categories = $store->merchantCategories;
        
        // Get all products with featured first
        $products = $store->products()
                         ->where('is_active', true)
                         ->with(['primaryImage', 'merchantCategory'])
                         ->orderByRaw('is_featured DESC, featured_order ASC, created_at DESC')
                         ->get();
        
        return view('stores.show', compact('store', 'categories', 'products'));
    }
}
