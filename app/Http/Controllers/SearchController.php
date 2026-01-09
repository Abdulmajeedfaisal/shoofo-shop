<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Merchant;
use App\Models\GlobalCategory;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    /**
     * Display search results page
     */
    public function index(Request $request)
    {
        $query = $request->input('q', '');
        $type = $request->input('type', 'all'); // all, products, stores
        $category = $request->input('category');
        $store = $request->input('store');
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');
        $sort = $request->input('sort', 'relevance');
        $inStock = $request->input('in_stock');

        $products = collect();
        $stores = collect();
        $productsCount = 0;
        $storesCount = 0;

        // Search Products
        if ($type === 'all' || $type === 'products') {
            $productsQuery = Product::query()
                ->where('is_active', true)
                ->whereHas('merchant', fn($q) => $q->where('status', 'approved'));

            // Text search
            if (!empty($query)) {
                $productsQuery->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                      ->orWhere('name_ar', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('description_ar', 'like', "%{$query}%")
                      ->orWhere('sku', 'like', "%{$query}%");
                });
            }

            // Category filter
            if ($category) {
                $productsQuery->whereHas('merchantCategory', function ($q) use ($category) {
                    $q->where('global_category_id', $category);
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
                default: // relevance - featured first
                    $productsQuery->orderByDesc('is_featured')
                                  ->orderBy('featured_order')
                                  ->orderByDesc('created_at');
            }

            $productsCount = $productsQuery->count();
            $products = $productsQuery
                ->with(['merchant', 'merchantCategory', 'primaryImage'])
                ->paginate(24)
                ->appends($request->query());
        }

        // Search Stores
        if ($type === 'all' || $type === 'stores') {
            $storesQuery = Merchant::query()->where('status', 'approved');

            if (!empty($query)) {
                $storesQuery->where(function ($q) use ($query) {
                    $q->where('store_name', 'like', "%{$query}%")
                      ->orWhere('store_name_ar', 'like', "%{$query}%")
                      ->orWhere('description', 'like', "%{$query}%")
                      ->orWhere('description_ar', 'like', "%{$query}%");
                });
            }

            $storesCount = $storesQuery->count();
            $stores = $storesQuery
                ->withCount('products')
                ->orderByDesc('is_featured')
                ->limit($type === 'stores' ? 50 : 6)
                ->get();
        }

        // Get categories for filter
        $categories = GlobalCategory::active()->get();

        // Get stores for filter
        $allStores = Merchant::approved()
            ->select('id', 'store_name', 'store_name_ar')
            ->orderBy('store_name')
            ->get();

        return view('search.index', [
            'query' => $query,
            'type' => $type,
            'products' => $products,
            'stores' => $stores,
            'productsCount' => $productsCount,
            'storesCount' => $storesCount,
            'categories' => $categories,
            'allStores' => $allStores,
            'selectedCategory' => $category,
            'selectedStore' => $store,
            'minPrice' => $minPrice,
            'maxPrice' => $maxPrice,
            'sort' => $sort,
            'inStock' => $inStock,
        ]);
    }

    /**
     * API endpoint for search suggestions (autocomplete)
     */
    public function suggestions(Request $request)
    {
        $query = $request->input('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Get product suggestions
        $products = Product::query()
            ->where('is_active', true)
            ->whereHas('merchant', fn($q) => $q->where('status', 'approved'))
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('name_ar', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'name_ar', 'slug', 'merchant_id')
            ->with('merchant:id,slug,store_name')
            ->limit(5)
            ->get()
            ->map(fn($p) => [
                'type' => 'product',
                'name' => app()->getLocale() === 'ar' && $p->name_ar ? $p->name_ar : $p->name,
                'url' => route('products.show', [$p->merchant->slug, $p->slug]),
            ]);

        // Get store suggestions
        $stores = Merchant::query()
            ->where('status', 'approved')
            ->where(function ($q) use ($query) {
                $q->where('store_name', 'like', "%{$query}%")
                  ->orWhere('store_name_ar', 'like', "%{$query}%");
            })
            ->select('id', 'store_name', 'store_name_ar', 'slug')
            ->limit(3)
            ->get()
            ->map(fn($s) => [
                'type' => 'store',
                'name' => app()->getLocale() === 'ar' && $s->store_name_ar ? $s->store_name_ar : $s->store_name,
                'url' => route('stores.show', $s->slug),
            ]);

        // Get category suggestions
        $categories = GlobalCategory::query()
            ->where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('name', 'like', "%{$query}%")
                  ->orWhere('name_ar', 'like', "%{$query}%");
            })
            ->select('id', 'name', 'name_ar', 'slug')
            ->limit(3)
            ->get()
            ->map(fn($c) => [
                'type' => 'category',
                'name' => app()->getLocale() === 'ar' && $c->name_ar ? $c->name_ar : $c->name,
                'url' => route('categories.show', $c->slug),
            ]);

        return response()->json([
            'products' => $products,
            'stores' => $stores,
            'categories' => $categories,
        ]);
    }
}
