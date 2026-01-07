<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\GlobalCategory;
use App\Models\Merchant;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display the luxury marketplace home page
     */
    public function index()
    {
        // Get active banners ordered by priority
        $banners = Banner::where('is_active', true)
            ->where(function($query) {
                $query->whereNull('start_date')
                      ->orWhere('start_date', '<=', now());
            })
            ->where(function($query) {
                $query->whereNull('end_date')
                      ->orWhere('end_date', '>=', now());
            })
            ->orderBy('order')
            ->get();

        // Get active global categories
        $globalCategories = GlobalCategory::active()->get();

        // Get featured stores (approved merchants)
        $featuredStores = Merchant::where('status', 'approved')
            ->where('is_featured', true)
            ->with('user')
            ->limit(6)
            ->get();

        return view('home', compact('banners', 'globalCategories', 'featuredStores'));
    }
}
