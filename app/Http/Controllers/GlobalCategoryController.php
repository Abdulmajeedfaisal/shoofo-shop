<?php

namespace App\Http\Controllers;

use App\Models\GlobalCategory;
use App\Models\Product;
use Illuminate\Http\Request;

class GlobalCategoryController extends Controller
{
    /**
     * Display a listing of all global categories
     */
    public function index()
    {
        $globalCategories = GlobalCategory::active()
            ->withCount('merchantCategories')
            ->get();

        return view('categories.index', compact('globalCategories'));
    }

    /**
     * Display products from all stores in a specific global category
     */
    public function show($slug)
    {
        // Find global category
        $globalCategory = GlobalCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get all products linked to this global category through merchant categories
        $products = Product::active()
            ->byGlobalCategory($globalCategory->id)
            ->with(['merchant', 'merchantCategory', 'primaryImage'])
            ->paginate(24);

        return view('categories.show', compact('globalCategory', 'products'));
    }
}
