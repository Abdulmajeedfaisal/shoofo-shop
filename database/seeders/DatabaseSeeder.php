<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Merchant;
use App\Models\GlobalCategory;
use App\Models\MerchantCategory;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Banner;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create storage directories
        $this->createStorageDirectories();
        
        // 1. Create Admin User
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@shoofo.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'locale' => 'en',
        ]);

        // 2. Create Merchant Users & Stores
        $merchants = $this->createMerchants();

        // 3. Create Global Categories
        $globalCategories = $this->createGlobalCategories();

        // 4. Create Merchant Categories
        $this->createMerchantCategories($merchants, $globalCategories);

        // 5. Create Products with Images
        $this->createProducts($merchants);

        // 6. Create Banners
        $this->createBanners();

        // 7. Create Regular Customer
        User::create([
            'name' => 'Customer',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'locale' => 'en',
        ]);

        $this->command->info('✅ Database seeded successfully with luxury data!');
    }

    private function createStorageDirectories()
    {
        $directories = [
            'public/merchants/logos',
            'public/products',
            'public/banners',
            'public/categories/icons',
        ];

        foreach ($directories as $dir) {
            if (!File::exists(storage_path('app/' . $dir))) {
                File::makeDirectory(storage_path('app/' . $dir), 0755, true);
            }
        }
    }

    private function createMerchants()
    {
        $merchantsData = [
            [
                'name' => 'Zara Store',
                'name_ar' => 'متجر زارا',
                'email' => 'zara@shoofo.com',
                'store_name' => 'Zara',
                'store_name_ar' => 'زارا',
                'description' => 'International fashion retailer offering trendy clothing and accessories for men, women, and children.',
                'description_ar' => 'متجر أزياء عالمي يقدم ملابس وإكسسوارات عصرية للرجال والنساء والأطفال.',
                'slug' => 'zara',
                'logo' => 'https://images.unsplash.com/photo-1567401893414-76b7b1e5a7a5?w=400&h=400&fit=crop&q=80',
                'is_featured' => true,
            ],
            [
                'name' => 'Nike Store',
                'name_ar' => 'متجر نايكي',
                'email' => 'nike@shoofo.com',
                'store_name' => 'Nike',
                'store_name_ar' => 'نايكي',
                'description' => 'Leading sports brand offering athletic footwear, apparel, and equipment.',
                'description_ar' => 'علامة رياضية رائدة تقدم أحذية وملابس ومعدات رياضية.',
                'slug' => 'nike',
                'logo' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400&h=400&fit=crop&q=80',
                'is_featured' => true,
            ],
            [
                'name' => 'Apple Store',
                'name_ar' => 'متجر أبل',
                'email' => 'apple@shoofo.com',
                'store_name' => 'Apple',
                'store_name_ar' => 'أبل',
                'description' => 'Premium technology products including iPhones, iPads, MacBooks, and accessories.',
                'description_ar' => 'منتجات تقنية فاخرة تشمل آيفون وآيباد وماك بوك وإكسسوارات.',
                'slug' => 'apple',
                'logo' => 'https://images.unsplash.com/photo-1611186871348-b1ce696e52c9?w=400&h=400&fit=crop&q=80',
                'is_featured' => true,
            ],
            [
                'name' => 'H&M Store',
                'name_ar' => 'متجر اتش اند ام',
                'email' => 'hm@shoofo.com',
                'store_name' => 'H&M',
                'store_name_ar' => 'اتش اند ام',
                'description' => 'Fashion and quality at the best price in a sustainable way.',
                'description_ar' => 'أزياء وجودة بأفضل سعر بطريقة مستدامة.',
                'slug' => 'hm',
                'logo' => 'https://images.unsplash.com/photo-1558769132-cb1aea1f1f57?w=400&h=400&fit=crop&q=80',
                'is_featured' => false,
            ],
        ];

        $merchants = [];
        foreach ($merchantsData as $data) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'merchant',
                'locale' => 'en',
            ]);

            $merchant = Merchant::create([
                'user_id' => $user->id,
                'store_name' => $data['store_name'],
                'store_name_ar' => $data['store_name_ar'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'description_ar' => $data['description_ar'] ?? $data['description'],
                'logo' => $data['logo'],
                'phone' => '+966 50 123 4567',
                'address' => 'Riyadh, Saudi Arabia',
                'status' => 'approved',
                'is_featured' => $data['is_featured'],
                'approved_at' => now(),
            ]);

            $merchants[] = $merchant;
        }

        return $merchants;
    }

    private function createGlobalCategories()
    {
        $categories = [
            [
                'name' => 'Fashion & Clothing',
                'name_ar' => 'الأزياء والملابس',
                'slug' => 'fashion-clothing',
                'description' => 'Discover the latest trends in fashion',
                'description_ar' => 'اكتشف أحدث صيحات الموضة',
                'order' => 1,
            ],
            [
                'name' => 'Electronics',
                'name_ar' => 'الإلكترونيات',
                'slug' => 'electronics',
                'description' => 'Latest technology and gadgets',
                'description_ar' => 'أحدث التقنيات والأجهزة',
                'order' => 2,
            ],
            [
                'name' => 'Sports & Fitness',
                'name_ar' => 'الرياضة واللياقة',
                'slug' => 'sports-fitness',
                'description' => 'Everything for your active lifestyle',
                'description_ar' => 'كل ما تحتاجه لنمط حياة نشط',
                'order' => 3,
            ],
            [
                'name' => 'Accessories',
                'name_ar' => 'الإكسسوارات',
                'slug' => 'accessories',
                'description' => 'Complete your look with perfect accessories',
                'description_ar' => 'أكمل إطلالتك بالإكسسوارات المثالية',
                'order' => 4,
            ],
        ];

        $globalCategories = [];
        foreach ($categories as $category) {
            $globalCategories[] = GlobalCategory::create($category);
        }

        return $globalCategories;
    }

    private function createMerchantCategories($merchants, $globalCategories)
    {
        // Zara Categories
        MerchantCategory::create([
            'merchant_id' => $merchants[0]->id,
            'global_category_id' => $globalCategories[0]->id,
            'name' => 'Women\'s Fashion',
            'name_ar' => 'أزياء نسائية',
            'slug' => 'womens-fashion',
            'order' => 1,
        ]);

        MerchantCategory::create([
            'merchant_id' => $merchants[0]->id,
            'global_category_id' => $globalCategories[0]->id,
            'name' => 'Men\'s Fashion',
            'name_ar' => 'أزياء رجالية',
            'slug' => 'mens-fashion',
            'order' => 2,
        ]);

        // Nike Categories
        MerchantCategory::create([
            'merchant_id' => $merchants[1]->id,
            'global_category_id' => $globalCategories[2]->id,
            'name' => 'Running Shoes',
            'name_ar' => 'أحذية الجري',
            'slug' => 'running-shoes',
            'order' => 1,
        ]);

        MerchantCategory::create([
            'merchant_id' => $merchants[1]->id,
            'global_category_id' => $globalCategories[2]->id,
            'name' => 'Sports Apparel',
            'name_ar' => 'ملابس رياضية',
            'slug' => 'sports-apparel',
            'order' => 2,
        ]);

        // Apple Categories
        MerchantCategory::create([
            'merchant_id' => $merchants[2]->id,
            'global_category_id' => $globalCategories[1]->id,
            'name' => 'iPhones',
            'name_ar' => 'آيفون',
            'slug' => 'iphones',
            'order' => 1,
        ]);

        MerchantCategory::create([
            'merchant_id' => $merchants[2]->id,
            'global_category_id' => $globalCategories[1]->id,
            'name' => 'MacBooks',
            'name_ar' => 'ماك بوك',
            'slug' => 'macbooks',
            'order' => 2,
        ]);

        // H&M Categories
        MerchantCategory::create([
            'merchant_id' => $merchants[3]->id,
            'global_category_id' => $globalCategories[0]->id,
            'name' => 'Casual Wear',
            'name_ar' => 'ملابس كاجوال',
            'slug' => 'casual-wear',
            'order' => 1,
        ]);
    }

    private function createProducts($merchants)
    {
        // Zara Products
        $zaraCategory = MerchantCategory::where('merchant_id', $merchants[0]->id)->first();
        
        $product1 = Product::create([
            'merchant_id' => $merchants[0]->id,
            'merchant_category_id' => $zaraCategory->id,
            'name' => 'Elegant Evening Dress',
            'name_ar' => 'فستان سهرة أنيق',
            'slug' => 'elegant-evening-dress',
            'description' => 'Stunning evening dress perfect for special occasions. Made from premium fabric with elegant design.',
            'description_ar' => 'فستان سهرة رائع مثالي للمناسبات الخاصة. مصنوع من قماش فاخر بتصميم أنيق.',
            'price' => 599.00,
            'sale_price' => 449.00,
            'quantity' => 25,
            'sku' => 'ZARA-DRESS-001',
            'is_active' => true,
            'is_featured' => true,
            'featured_order' => 1,
        ]);
        
        // Add product image
        ProductImage::create([
            'product_id' => $product1->id,
            'image' => 'https://images.unsplash.com/photo-1566174053879-31528523f8ae?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);

        $product2 = Product::create([
            'merchant_id' => $merchants[0]->id,
            'merchant_category_id' => $zaraCategory->id,
            'name' => 'Classic Blazer',
            'name_ar' => 'بليزر كلاسيكي',
            'slug' => 'classic-blazer',
            'description' => 'Timeless blazer that adds sophistication to any outfit.',
            'description_ar' => 'بليزر خالد يضيف الأناقة لأي إطلالة.',
            'price' => 399.00,
            'quantity' => 30,
            'sku' => 'ZARA-BLZR-001',
            'is_active' => true,
        ]);
        
        ProductImage::create([
            'product_id' => $product2->id,
            'image' => 'https://images.unsplash.com/photo-1507679799987-c73779587ccf?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);

        // Nike Products
        $nikeCategory = MerchantCategory::where('merchant_id', $merchants[1]->id)->first();
        
        $product3 = Product::create([
            'merchant_id' => $merchants[1]->id,
            'merchant_category_id' => $nikeCategory->id,
            'name' => 'Air Max Running Shoes',
            'name_ar' => 'حذاء جري اير ماكس',
            'slug' => 'air-max-running-shoes',
            'description' => 'Premium running shoes with advanced cushioning technology for maximum comfort.',
            'description_ar' => 'حذاء جري فاخر بتقنية توسيد متقدمة لأقصى راحة.',
            'price' => 899.00,
            'quantity' => 50,
            'sku' => 'NIKE-AIRMAX-001',
            'is_active' => true,
            'is_featured' => true,
            'featured_order' => 1,
        ]);
        
        ProductImage::create([
            'product_id' => $product3->id,
            'image' => 'https://images.unsplash.com/photo-1606107557195-0e29a4b5b4aa?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);

        $product4 = Product::create([
            'merchant_id' => $merchants[1]->id,
            'merchant_category_id' => $nikeCategory->id,
            'name' => 'Pro Training T-Shirt',
            'name_ar' => 'تيشيرت تدريب احترافي',
            'slug' => 'pro-training-tshirt',
            'description' => 'Breathable training shirt designed for peak performance.',
            'description_ar' => 'تيشيرت تدريب قابل للتنفس مصمم للأداء الأمثل.',
            'price' => 149.00,
            'sale_price' => 99.00,
            'quantity' => 100,
            'sku' => 'NIKE-TSHIRT-001',
            'is_active' => true,
        ]);
        
        ProductImage::create([
            'product_id' => $product4->id,
            'image' => 'https://images.unsplash.com/photo-1556821840-3a63f95609a7?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);

        // Apple Products
        $appleCategory = MerchantCategory::where('merchant_id', $merchants[2]->id)->first();
        
        $product5 = Product::create([
            'merchant_id' => $merchants[2]->id,
            'merchant_category_id' => $appleCategory->id,
            'name' => 'iPhone 15 Pro Max',
            'name_ar' => 'آيفون 15 برو ماكس',
            'slug' => 'iphone-15-pro-max',
            'description' => 'The ultimate iPhone with titanium design, A17 Pro chip, and advanced camera system.',
            'description_ar' => 'الآيفون الأمثل بتصميم تيتانيوم، معالج A17 Pro، ونظام كاميرا متقدم.',
            'price' => 5999.00,
            'quantity' => 15,
            'sku' => 'APPLE-IP15PM-001',
            'is_active' => true,
            'is_featured' => true,
            'featured_order' => 1,
        ]);
        
        ProductImage::create([
            'product_id' => $product5->id,
            'image' => 'https://images.unsplash.com/photo-1510557880182-3d4d3cba35a5?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);

        $product6 = Product::create([
            'merchant_id' => $merchants[2]->id,
            'merchant_category_id' => $appleCategory->id,
            'name' => 'MacBook Pro 16"',
            'name_ar' => 'ماك بوك برو 16 بوصة',
            'slug' => 'macbook-pro-16',
            'description' => 'Powerful laptop with M3 Pro chip, stunning Liquid Retina XDR display.',
            'description_ar' => 'لابتوب قوي بمعالج M3 Pro، شاشة Liquid Retina XDR مذهلة.',
            'price' => 12999.00,
            'sale_price' => 11999.00,
            'quantity' => 8,
            'sku' => 'APPLE-MBP16-001',
            'is_active' => true,
        ]);
        
        ProductImage::create([
            'product_id' => $product6->id,
            'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);

        // H&M Products
        $hmCategory = MerchantCategory::where('merchant_id', $merchants[3]->id)->first();
        
        $product7 = Product::create([
            'merchant_id' => $merchants[3]->id,
            'merchant_category_id' => $hmCategory->id,
            'name' => 'Cotton T-Shirt',
            'name_ar' => 'تيشيرت قطني',
            'slug' => 'cotton-tshirt',
            'description' => 'Comfortable cotton t-shirt perfect for everyday wear.',
            'description_ar' => 'تيشيرت قطني مريح مثالي للارتداء اليومي.',
            'price' => 79.00,
            'quantity' => 200,
            'sku' => 'HM-TSHIRT-001',
            'is_active' => true,
        ]);
        
        ProductImage::create([
            'product_id' => $product7->id,
            'image' => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);

        $product8 = Product::create([
            'merchant_id' => $merchants[3]->id,
            'merchant_category_id' => $hmCategory->id,
            'name' => 'Denim Jeans',
            'name_ar' => 'بنطال جينز',
            'slug' => 'denim-jeans',
            'description' => 'Classic denim jeans with modern fit.',
            'description_ar' => 'بنطال جينز كلاسيكي بقصة عصرية.',
            'price' => 199.00,
            'quantity' => 75,
            'sku' => 'HM-JEANS-001',
            'is_active' => true,
        ]);
        
        ProductImage::create([
            'product_id' => $product8->id,
            'image' => 'https://images.unsplash.com/photo-1542272604-787c3835535d?w=800&h=800&fit=crop&q=80',
            'order' => 1,
            'is_primary' => true,
        ]);
    }

    private function createBanners()
    {
        // Banner 1: Luxury Fashion Store
        Banner::create([
            'title' => 'Welcome to SHOOFO',
            'title_ar' => 'مرحباً بك في شوفو',
            'subtitle' => 'Your Gateway to Luxury Brands',
            'subtitle_ar' => 'بوابتك إلى العلامات الفاخرة',
            'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1920&h=1080&fit=crop&q=80',
            'link' => '/stores',
            'order' => 1,
            'is_active' => true,
        ]);

        // Banner 2: Fashion & Style
        Banner::create([
            'title' => 'Discover Luxury Fashion',
            'title_ar' => 'اكتشف الأزياء الفاخرة',
            'subtitle' => 'Exclusive Collections from Premium Brands',
            'subtitle_ar' => 'مجموعات حصرية من العلامات الفاخرة',
            'image' => 'https://images.unsplash.com/photo-1490481651871-ab68de25d43d?w=1920&h=1080&fit=crop&q=80',
            'link' => '/categories/fashion-clothing',
            'order' => 2,
            'is_active' => true,
        ]);
        
        // Banner 3: Premium Electronics
        Banner::create([
            'title' => 'Premium Technology',
            'title_ar' => 'تقنية متميزة',
            'subtitle' => 'Latest Gadgets & Electronics',
            'subtitle_ar' => 'أحدث الأجهزة والإلكترونيات',
            'image' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1920&h=1080&fit=crop&q=80',
            'link' => '/categories/electronics',
            'order' => 3,
            'is_active' => true,
        ]);
    }
}
