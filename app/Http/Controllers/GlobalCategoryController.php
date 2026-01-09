<?php

namespace App\Http\Controllers;

use App\Models\GlobalCategory;
use App\Models\Product;
use App\Models\Merchant;
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
    public function show(Request $request, $slug)
    {
        // Find global category
        $globalCategory = GlobalCategory::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Get filter parameters
        $search = $request->input('q', '');
        $store = $request->input('store');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort', 'featured');
        $inStock = $request->input('in_stock');

        // Build products query
        $productsQuery = Product::active()
            ->byGlobalCategory($globalCategory->id);

        // Search within category
        if (!empty($search)) {
            $productsQuery->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('name_ar', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('description_ar', 'like', "%{$search}%");
            });
        }

        // Store filter
        if ($store) {
            $productsQuery->where('merchant_id', $store);
        }

        // Price filter
        if ($minPrice) {
            $productsQuery->where(function ($q) use ($minPrice) {
                $q->where('sale_price', '>=', $minPrice)
                  ->orWhere(function ($q2) use ($minPrice) {
                      $q2->whereNull('sale_price')->where('price', '>=', $minPrice);
                  });
            });
        }

        if ($maxPrice) {
            $productsQuery->where(function ($q) use ($maxPrice) {
                $q->where('sale_price', '<=', $maxPrice)
                  ->orWhere(function ($q2) use ($maxPrice) {
                      $q2->whereNull('sale_price')->where('price', '<=', $maxPrice);
                  });
            });
        }

        // In stock filter
        if ($inStock) {
            $productsQuery->where('quantity', '>', 0);
        }

        // Sorting
        switch ($sort) {
            case 'price_low':
                $productsQuery->orderByRaw('COALESCE(sale_price, price) ASC');
                break;
            case 'price_high':
                $productsQuery->orderByRaw('COALESCE(sale_price, price) DESC');
                break;
            case 'newest':
                $productsQuery->orderBy('created_at', 'desc');
                break;
            case 'popular':
                $productsQuery->orderBy('views_count', 'desc');
                break;
            default: // featured
                $productsQuery->orderByDesc('is_featured')
                              ->orderBy('featured_order')
                              ->orderByDesc('created_at');
        }

        // Get total count before pagination
        $totalProducts = $productsQuery->count();

        // Get paginated products
        $products = $productsQuery
            ->with(['merchant', 'merchantCategory', 'primaryImage'])
            ->paginate(24)
            ->appends($request->query());

        // Get stores that have products in this category for filter
        $categoryStores = Merchant::approved()
            ->whereHas('products', function ($q) use ($globalCategory) {
                $q->where('is_active', true)
                  ->whereHas('merchantCategory', function ($q2) use ($globalCategory) {
                      $q2->where('global_category_id', $globalCategory->id);
                  });
            })
            ->select('id', 'store_name', 'store_name_ar')
            ->withCount(['products' => function ($q) use ($globalCategory) {
                $q->where('is_active', true)
                  ->whereHas('merchantCategory', function ($q2) use ($globalCategory) {
                      $q2->where('global_category_id', $globalCategory->id);
                  });
            }])
            ->orderBy('store_name')
            ->get();

        return view('categories.show', [
            'globalCategory' => $globalCategory,
            'products' => $products,
            'totalProducts' => $totalProducts,
            'categoryStores' => $categoryStores,
            'search' => $search,
            'selectedStore' => $store,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'sort' => $sort,
            'inStock' => $inStock,
        ]);
    }
}
