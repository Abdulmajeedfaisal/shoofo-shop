# Design Document: SHOOFO - Luxury Smart Marketplace

## Executive Summary

This design document outlines the technical architecture, visual design system, and implementation strategy for SHOOFO - a luxury smart marketplace that combines prestige with intelligent technology. Every design decision serves the ultimate goal: **making merchants feel prestigious and customers feel amazed**.

---

## 1. Visual Design System

### 1.1 Color Palette (Luxury & Prestige)

Based on research of premium brands and luxury e-commerce trends, our color palette conveys exclusivity, sophistication, and trust.

#### Primary Colors (Brand Identity)
```
Deep Midnight Blue: #0A1628 (Primary Dark - Authority & Trust)
Royal Gold: #D4AF37 (Accent - Luxury & Prestige)
Pure White: #FFFFFF (Background - Cleanliness & Space)
Soft Cream: #FAF9F6 (Secondary Background - Warmth)
```

#### Secondary Colors (UI Elements)
```
Charcoal: #2D3748 (Text Primary)
Slate Gray: #64748B (Text Secondary)
Light Gray: #E2E8F0 (Borders & Dividers)
Success Green: #10B981 (Success States)
Error Red: #EF4444 (Error States)
```

#### Accent Colors (Highlights & CTAs)
```
Rose Gold: #B76E79 (Secondary Accent - Elegance)
Silver: #C0C0C0 (Tertiary Accent - Sophistication)
Deep Purple: #6B46C1 (Premium Features)
```

### 1.2 Typography (Elegant & Refined)

#### Font Families
Based on luxury branding research, we'll use a combination of serif and sans-serif fonts:

**Primary Font (Headings):**
- Font: "Playfair Display" (Serif - Elegant & Luxurious)
- Fallback: Georgia, "Times New Roman", serif
- Usage: H1, H2, H3, Brand Name, Hero Sections
- Weights: 400 (Regular), 600 (SemiBold), 700 (Bold)

**Secondary Font (Body Text):**
- Font: "Inter" (Sans-Serif - Modern & Readable)
- Fallback: -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif
- Usage: Body text, UI elements, Buttons
- Weights: 300 (Light), 400 (Regular), 500 (Medium), 600 (SemiBold)

**Accent Font (Special Elements):**
- Font: "Cormorant Garamond" (Serif - Refined)
- Usage: Quotes, Special Callouts, Luxury Product Names
- Weights: 400 (Regular), 600 (SemiBold)


#### Typography Scale
```
H1: 3.5rem (56px) - Line Height: 1.2 - Weight: 700 - Letter Spacing: -0.02em
H2: 2.5rem (40px) - Line Height: 1.3 - Weight: 600 - Letter Spacing: -0.01em
H3: 2rem (32px) - Line Height: 1.4 - Weight: 600 - Letter Spacing: 0
H4: 1.5rem (24px) - Line Height: 1.5 - Weight: 600 - Letter Spacing: 0
H5: 1.25rem (20px) - Line Height: 1.5 - Weight: 500 - Letter Spacing: 0
Body Large: 1.125rem (18px) - Line Height: 1.7 - Weight: 400
Body: 1rem (16px) - Line Height: 1.6 - Weight: 400
Body Small: 0.875rem (14px) - Line Height: 1.5 - Weight: 400
Caption: 0.75rem (12px) - Line Height: 1.4 - Weight: 400
```

### 1.3 Spacing System (Generous & Luxurious)

Luxury design requires generous whitespace. Our spacing scale:

```
xs: 0.25rem (4px)
sm: 0.5rem (8px)
md: 1rem (16px)
lg: 1.5rem (24px)
xl: 2rem (32px)
2xl: 3rem (48px)
3xl: 4rem (64px)
4xl: 6rem (96px)
5xl: 8rem (128px)
```

**Spacing Guidelines:**
- Section padding: 4xl to 5xl (96px - 128px)
- Card padding: xl to 2xl (32px - 48px)
- Element margins: lg to xl (24px - 32px)
- Grid gaps: lg to 2xl (24px - 48px)

### 1.4 Shadows & Elevation (Sophisticated Depth)

```css
/* Subtle Shadow (Cards at rest) */
shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05)

/* Card Shadow (Default elevation) */
shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)

/* Hover Shadow (Interactive elements) */
shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)

/* Premium Shadow (Featured elements) */
shadow-xl: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)

/* Luxury Shadow (Hero sections) */
shadow-2xl: 0 25px 50px -12px rgba(0, 0, 0, 0.25)
```


### 1.5 Border Radius (Refined Corners)

```
none: 0
sm: 0.25rem (4px) - Small elements
md: 0.5rem (8px) - Buttons, inputs
lg: 0.75rem (12px) - Cards
xl: 1rem (16px) - Large cards
2xl: 1.5rem (24px) - Hero sections
full: 9999px - Circular elements
```

### 1.6 Animation & Transitions (Buttery Smooth)

All animations must be smooth (60fps) and feel premium, never jarring.

#### Timing Functions (Easing)
```css
/* Smooth ease (Default) */
ease-smooth: cubic-bezier(0.4, 0.0, 0.2, 1)

/* Elegant entrance */
ease-in-elegant: cubic-bezier(0.4, 0.0, 1, 1)

/* Sophisticated exit */
ease-out-elegant: cubic-bezier(0.0, 0.0, 0.2, 1)

/* Premium bounce */
ease-bounce: cubic-bezier(0.68, -0.55, 0.265, 1.55)
```

#### Duration Scale
```
fast: 150ms - Micro-interactions
normal: 300ms - Standard transitions
slow: 500ms - Page transitions
cinematic: 1000ms - Hero animations
entrance: 2000ms - Store entrance animation
```

#### Common Transitions
```css
/* Hover effects */
transition: all 300ms cubic-bezier(0.4, 0.0, 0.2, 1);

/* Fade in/out */
transition: opacity 300ms ease-smooth;

/* Scale effects */
transition: transform 300ms ease-smooth;

/* Combined (Premium) */
transition: all 300ms ease-smooth, transform 300ms ease-bounce;
```

---

## 2. Component Design System

### 2.1 Buttons (Premium CTAs)

#### Primary Button (Main Actions)
```css
Background: Royal Gold (#D4AF37)
Text: Deep Midnight Blue (#0A1628)
Padding: 1rem 2rem (16px 32px)
Border Radius: 0.5rem (8px)
Font: Inter, 500 weight, 1rem
Hover: Scale 1.05, Shadow-lg
Active: Scale 0.98
Transition: 300ms ease-smooth
```

#### Secondary Button (Alternative Actions)
```css
Background: Transparent
Border: 2px solid Deep Midnight Blue
Text: Deep Midnight Blue
Padding: 1rem 2rem
Hover: Background Deep Midnight Blue, Text White
```

#### Ghost Button (Subtle Actions)
```css
Background: Transparent
Text: Charcoal
Hover: Background Light Gray
```


### 2.2 Cards (Product & Store Cards)

#### Product Card (Global Category View)
```
Container:
- Background: White
- Border Radius: 1rem (16px)
- Shadow: shadow-md
- Padding: 1.5rem (24px)
- Hover: shadow-xl, transform scale(1.02)
- Transition: 300ms ease-smooth

Image Container:
- Aspect Ratio: 4:3
- Border Radius: 0.75rem (12px)
- Overflow: hidden
- Background: Soft Cream

Store Badge:
- Position: Absolute top-right
- Size: 40px x 40px
- Border: 2px solid White
- Shadow: shadow-md
- Border Radius: full

Content:
- Store Name: Body Small, Slate Gray
- Product Name: H5, Charcoal, 2 lines max
- Price: H4, Royal Gold
- Category: Caption, Slate Gray
```

#### Store Card (Directory)
```
Container:
- Background: White
- Border Radius: 1.5rem (24px)
- Shadow: shadow-lg
- Padding: 2rem (32px)
- Hover: shadow-2xl, transform translateY(-8px)
- Transition: 500ms ease-smooth

Logo Container:
- Size: 120px x 120px
- Border Radius: full
- Background: Soft Cream
- Margin Bottom: 1.5rem

Content:
- Store Name: H3, Playfair Display
- Description: Body, 3 lines max
- CTA Button: Primary Button
```

### 2.3 Navigation (Elegant & Accessible)

#### Main Navigation Bar
```
Container:
- Background: White with backdrop blur
- Height: 80px
- Shadow: shadow-sm
- Position: Sticky top
- Z-index: 50

Logo:
- Height: 48px
- Font: Playfair Display, 2rem, Bold

Menu Items:
- Font: Inter, 1rem, Medium
- Color: Charcoal
- Hover: Royal Gold
- Active: Royal Gold with underline
- Transition: 300ms

Icons:
- Size: 24px
- Color: Charcoal
- Hover: Royal Gold
```


### 2.4 Forms (Refined Input)

#### Text Input
```css
Background: White
Border: 1px solid Light Gray
Border Radius: 0.5rem (8px)
Padding: 0.75rem 1rem (12px 16px)
Font: Inter, 1rem
Focus: Border Royal Gold, Shadow-md
Placeholder: Slate Gray
```

#### Select Dropdown
```css
Same as Text Input
Icon: Chevron down, Slate Gray
Hover: Border Charcoal
```

#### Checkbox/Radio
```css
Size: 20px x 20px
Border: 2px solid Light Gray
Border Radius: 0.25rem (checkbox) / full (radio)
Checked: Background Royal Gold, Border Royal Gold
```

---

## 3. Page-Specific Designs

### 3.1 Landing Page (Marketplace Home)

#### Hero Section (Cinematic Banners)
```
Container:
- Height: 80vh (min 600px)
- Background: Gradient overlay on image
- Position: Relative

Banner Slider:
- Transition: Fade 1000ms ease-smooth
- Auto-play: 5 seconds
- Navigation: Elegant dots at bottom
- Swipe: Enabled on mobile

Content Overlay:
- Position: Absolute center
- Max Width: 800px
- Text Align: Center
- Heading: H1, White, Playfair Display
- Subheading: Body Large, White with opacity 90%
- CTA: Primary Button (large)
```

#### Global Categories Section
```
Container:
- Padding: 5xl vertical (128px)
- Background: Soft Cream

Heading:
- H2, Center aligned
- Margin Bottom: 3xl (64px)

Category Grid:
- Columns: 4 (desktop), 2 (tablet), 1 (mobile)
- Gap: 2xl (48px)

Category Card:
- Background: White
- Padding: 2xl (48px)
- Border Radius: xl (16px)
- Text Align: Center
- Hover: shadow-xl, transform scale(1.05)

Icon:
- Size: 80px x 80px
- Color: Royal Gold
- Margin Bottom: lg (24px)

Name:
- H4, Charcoal
- Bilingual display
```


#### Featured Stores Section
```
Container:
- Padding: 5xl vertical
- Background: White

Heading:
- H2, Center aligned
- Margin Bottom: 3xl

Store Grid:
- Columns: 3 (desktop), 2 (tablet), 1 (mobile)
- Gap: 2xl

Store Card: (See 2.2 Cards)
```

### 3.2 Store Entrance Animation

This is the signature "prestige moment" - the 2-3 second animation when entering a store.

```
Animation Sequence:

1. Fade Out Current Page (300ms)
   - Opacity: 1 → 0
   - Transform: scale(1) → scale(0.95)

2. Show Store Logo (1500ms)
   - Background: Deep Midnight Blue
   - Logo: Center, fade in + scale
   - Animation: 
     * 0-500ms: Fade in (opacity 0 → 1)
     * 500-1000ms: Scale (0.8 → 1.1)
     * 1000-1500ms: Scale (1.1 → 1)
   - Easing: cubic-bezier(0.68, -0.55, 0.265, 1.55)

3. Fade to Store Page (500ms)
   - Logo fade out
   - Store page fade in
   - Transform: scale(0.95) → scale(1)

Total Duration: 2300ms
Skip: Click anywhere to fast-forward
```

#### Implementation (Alpine.js)
```html
<div x-data="{ entering: true }" 
     x-init="setTimeout(() => entering = false, 2300)"
     @click="entering = false">
  
  <!-- Animation Overlay -->
  <div x-show="entering" 
       x-transition:leave="transition ease-in duration-500"
       class="fixed inset-0 z-50 bg-midnight flex items-center justify-center">
    
    <!-- Store Logo -->
    <img :src="storeLogo" 
         x-transition:enter="transition duration-1500"
         x-transition:enter-start="opacity-0 scale-75"
         x-transition:enter-end="opacity-100 scale-100"
         class="w-48 h-48 object-contain">
  </div>
  
  <!-- Store Page Content -->
  <div x-show="!entering" 
       x-transition:enter="transition duration-500"
       x-transition:enter-start="opacity-0 scale-95"
       x-transition:enter-end="opacity-100 scale-100">
    <!-- Store content here -->
  </div>
</div>
```


### 3.3 Store Page Layout

```
Header Section:
- Background: Soft Cream
- Padding: 3xl vertical
- Text Align: Center

Store Logo:
- Size: 150px x 150px
- Border: 4px solid White
- Shadow: shadow-xl
- Border Radius: full
- Margin Bottom: xl

Store Name:
- H1, Playfair Display
- Margin Bottom: md

Store Description:
- Body Large, Slate Gray
- Max Width: 600px
- Center aligned

Categories Tabs:
- Background: White
- Padding: lg
- Border Bottom: 1px solid Light Gray
- Sticky: top 80px (below nav)

Tab Item:
- Padding: md lg
- Font: Inter, Medium
- Color: Charcoal
- Active: Royal Gold, Border Bottom 2px
- Hover: Royal Gold
- Transition: 300ms

Products Grid:
- Padding: 3xl vertical
- Columns: 4 (desktop), 3 (tablet), 2 (mobile)
- Gap: 2xl

Featured Products:
- Display: First in grid
- Size: 2x larger cards
- Badge: "Featured" in Royal Gold
```

### 3.4 Product Detail Page

```
Layout: Two Column (Image | Details)

Image Gallery (Left Column):
- Main Image: Large, 600px x 600px
- Thumbnails: Below, 80px x 80px each
- Lightbox: Click to expand
- Zoom: Hover to zoom in
- Transition: 300ms smooth

Details (Right Column):
- Store Badge: Logo + Name (clickable)
- Product Name: H2, Playfair Display
- Price: H3, Royal Gold
- Sale Price: Original crossed, Sale in Royal Gold
- Category: Caption, Slate Gray
- Description: Body, Line Height 1.7
- Quantity Selector: Elegant +/- buttons
- Add to Cart: Primary Button (large)
- Wishlist: Ghost Button with heart icon

Breadcrumb:
- Position: Top
- Font: Body Small
- Separator: "/" in Slate Gray
- Links: Hover Royal Gold
```


---

## 4. Technical Architecture

### 4.1 Technology Stack

#### Backend
```
Framework: Laravel 12
PHP Version: 8.2+
Database: SQLite (Development) / MySQL (Production)
Admin Panel: Filament 3.3
Authentication: Laravel Breeze
Queue: Database Queue
Cache: Database Cache
```

#### Frontend
```
CSS Framework: Tailwind CSS 3
JavaScript: Alpine.js 3.4
Build Tool: Vite 7
Icons: Heroicons
Fonts: Google Fonts (Playfair Display, Inter, Cormorant Garamond)
```

#### Additional Libraries
```
Image Optimization: Intervention Image
Slugs: Laravel Str Helper
Localization: Laravel Lang
Notifications: Laravel Notifications
```

### 4.2 Database Schema

#### Global Categories Table
```sql
CREATE TABLE global_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    name_ar VARCHAR(255),
    slug VARCHAR(255) UNIQUE NOT NULL,
    icon VARCHAR(255), -- Path to icon image
    description TEXT,
    description_ar TEXT,
    order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    INDEX idx_slug (slug),
    INDEX idx_order (order),
    INDEX idx_active (is_active)
);
```

#### Merchant Categories Table
```sql
CREATE TABLE merchant_categories (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    merchant_id BIGINT UNSIGNED NOT NULL,
    global_category_id BIGINT UNSIGNED NOT NULL,
    name VARCHAR(255) NOT NULL,
    name_ar VARCHAR(255),
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    description_ar TEXT,
    order INT DEFAULT 0,
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE CASCADE,
    FOREIGN KEY (global_category_id) REFERENCES global_categories(id) ON DELETE RESTRICT,
    UNIQUE KEY unique_merchant_slug (merchant_id, slug),
    INDEX idx_merchant (merchant_id),
    INDEX idx_global_category (global_category_id),
    INDEX idx_active (is_active)
);
```


#### Products Table (Updated)
```sql
CREATE TABLE products (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    merchant_id BIGINT UNSIGNED NOT NULL,
    merchant_category_id BIGINT UNSIGNED NOT NULL, -- Changed from category_id
    name VARCHAR(255) NOT NULL,
    name_ar VARCHAR(255),
    slug VARCHAR(255) NOT NULL,
    description TEXT,
    description_ar TEXT,
    price DECIMAL(10, 2) NOT NULL,
    sale_price DECIMAL(10, 2),
    quantity INT DEFAULT 0,
    sku VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    is_featured BOOLEAN DEFAULT FALSE, -- For Hero Products
    featured_order INT, -- Order within featured products
    views_count INT DEFAULT 0,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE CASCADE,
    FOREIGN KEY (merchant_category_id) REFERENCES merchant_categories(id) ON DELETE CASCADE,
    UNIQUE KEY unique_merchant_slug (merchant_id, slug),
    INDEX idx_merchant (merchant_id),
    INDEX idx_category (merchant_category_id),
    INDEX idx_active (is_active),
    INDEX idx_featured (is_featured),
    INDEX idx_price (price)
);
```

#### Carts Table
```sql
CREATE TABLE carts (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_cart (user_id)
);
```

#### Cart Items Table
```sql
CREATE TABLE cart_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    cart_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    quantity INT NOT NULL DEFAULT 1,
    price DECIMAL(10, 2) NOT NULL, -- Price at time of adding
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE,
    UNIQUE KEY unique_cart_product (cart_id, product_id)
);
```


#### Orders Table
```sql
CREATE TABLE orders (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT UNSIGNED NOT NULL,
    order_number VARCHAR(50) UNIQUE NOT NULL,
    status ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    subtotal DECIMAL(10, 2) NOT NULL,
    tax DECIMAL(10, 2) DEFAULT 0,
    shipping DECIMAL(10, 2) DEFAULT 0,
    total DECIMAL(10, 2) NOT NULL,
    
    -- Shipping Info
    shipping_name VARCHAR(255) NOT NULL,
    shipping_email VARCHAR(255) NOT NULL,
    shipping_phone VARCHAR(50) NOT NULL,
    shipping_address TEXT NOT NULL,
    shipping_city VARCHAR(100) NOT NULL,
    shipping_country VARCHAR(100) NOT NULL,
    shipping_postal_code VARCHAR(20),
    
    -- Payment Info
    payment_method VARCHAR(50),
    payment_status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
    
    notes TEXT,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE RESTRICT,
    INDEX idx_user (user_id),
    INDEX idx_status (status),
    INDEX idx_order_number (order_number)
);
```

#### Order Items Table
```sql
CREATE TABLE order_items (
    id BIGINT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    order_id BIGINT UNSIGNED NOT NULL,
    product_id BIGINT UNSIGNED NOT NULL,
    merchant_id BIGINT UNSIGNED NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    product_name_ar VARCHAR(255),
    quantity INT NOT NULL,
    price DECIMAL(10, 2) NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE RESTRICT,
    FOREIGN KEY (merchant_id) REFERENCES merchants(id) ON DELETE RESTRICT,
    INDEX idx_order (order_id),
    INDEX idx_merchant (merchant_id)
);
```

### 4.3 Key Models & Relationships

#### GlobalCategory Model
```php
class GlobalCategory extends Model
{
    protected $fillable = ['name', 'name_ar', 'slug', 'icon', 'description', 'description_ar', 'order', 'is_active'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function merchantCategories()
    {
        return $this->hasMany(MerchantCategory::class);
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
```


#### MerchantCategory Model
```php
class MerchantCategory extends Model
{
    protected $fillable = ['merchant_id', 'global_category_id', 'name', 'name_ar', 'slug', 'description', 'description_ar', 'order', 'is_active'];
    
    protected $casts = ['is_active' => 'boolean'];
    
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    
    public function globalCategory()
    {
        return $this->belongsTo(GlobalCategory::class);
    }
    
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    public function featuredProducts()
    {
        return $this->products()->where('is_featured', true)->orderBy('featured_order');
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('order');
    }
}
```

#### Product Model (Updated)
```php
class Product extends Model
{
    protected $fillable = [
        'merchant_id', 'merchant_category_id', 'name', 'name_ar', 'slug',
        'description', 'description_ar', 'price', 'sale_price', 'quantity',
        'sku', 'is_active', 'is_featured', 'featured_order'
    ];
    
    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
    ];
    
    public function merchant()
    {
        return $this->belongsTo(Merchant::class);
    }
    
    public function merchantCategory()
    {
        return $this->belongsTo(MerchantCategory::class);
    }
    
    public function globalCategory()
    {
        return $this->merchantCategory->globalCategory();
    }
    
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }
    
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }
    
    public function getCurrentPrice()
    {
        return $this->sale_price ?? $this->price;
    }
    
    public function isInStock()
    {
        return $this->quantity > 0;
    }
    
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true)->orderBy('featured_order');
    }
    
    public function scopeByGlobalCategory($query, $globalCategoryId)
    {
        return $query->whereHas('merchantCategory', function($q) use ($globalCategoryId) {
            $q->where('global_category_id', $globalCategoryId);
        });
    }
}
```


### 4.4 Key Controllers

#### HomeController
```php
class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::active()->orderBy('order')->get();
        $globalCategories = GlobalCategory::active()->get();
        $featuredStores = Merchant::where('is_featured', true)
                                  ->where('status', 'approved')
                                  ->limit(6)
                                  ->get();
        
        return view('home', compact('banners', 'globalCategories', 'featuredStores'));
    }
}
```

#### GlobalCategoryController
```php
class GlobalCategoryController extends Controller
{
    public function show($slug)
    {
        $globalCategory = GlobalCategory::where('slug', $slug)->firstOrFail();
        
        $products = Product::active()
                          ->byGlobalCategory($globalCategory->id)
                          ->with(['merchant', 'merchantCategory', 'primaryImage'])
                          ->paginate(24);
        
        return view('categories.show', compact('globalCategory', 'products'));
    }
}
```

#### StoreController
```php
class StoreController extends Controller
{
    public function index()
    {
        $stores = Merchant::where('status', 'approved')
                         ->with('user')
                         ->paginate(12);
        
        return view('stores.index', compact('stores'));
    }
    
    public function show($slug)
    {
        $store = Merchant::where('slug', $slug)
                        ->where('status', 'approved')
                        ->firstOrFail();
        
        $categories = $store->merchantCategories()->active()->get();
        $products = $store->products()->active()->with('primaryImage')->get();
        
        return view('stores.show', compact('store', 'categories', 'products'));
    }
}
```

#### ProductController
```php
class ProductController extends Controller
{
    public function show($merchantSlug, $productSlug)
    {
        $merchant = Merchant::where('slug', $merchantSlug)->firstOrFail();
        
        $product = Product::where('slug', $productSlug)
                         ->where('merchant_id', $merchant->id)
                         ->where('is_active', true)
                         ->with(['images', 'merchantCategory', 'merchant'])
                         ->firstOrFail();
        
        // Increment views
        $product->increment('views_count');
        
        return view('products.show', compact('product', 'merchant'));
    }
}
```


#### CartController
```php
class CartController extends Controller
{
    public function index()
    {
        $cart = auth()->user()->cart()->with('items.product.primaryImage')->first();
        
        return view('cart.index', compact('cart'));
    }
    
    public function add(Request $request, Product $product)
    {
        $cart = auth()->user()->cart()->firstOrCreate([]);
        
        $cartItem = $cart->items()->updateOrCreate(
            ['product_id' => $product->id],
            [
                'quantity' => $request->quantity ?? 1,
                'price' => $product->getCurrentPrice()
            ]
        );
        
        return redirect()->back()->with('success', 'Product added to cart');
    }
    
    public function update(Request $request, CartItem $cartItem)
    {
        $cartItem->update(['quantity' => $request->quantity]);
        
        return redirect()->back()->with('success', 'Cart updated');
    }
    
    public function remove(CartItem $cartItem)
    {
        $cartItem->delete();
        
        return redirect()->back()->with('success', 'Item removed from cart');
    }
}
```

---

## 5. Filament Admin & Merchant Panels

### 5.1 Admin Panel Customization

#### Theme Configuration
```php
// app/Providers/Filament/AdminPanelProvider.php

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('admin')
        ->path('admin')
        ->brandName('SHOOFO Admin')
        ->brandLogo(asset('images/logo-admin.svg'))
        ->colors([
            'primary' => '#D4AF37', // Royal Gold
            'gray' => '#64748B',
            'success' => '#10B981',
            'danger' => '#EF4444',
        ])
        ->font('Inter')
        ->darkMode(false)
        ->maxContentWidth('full')
        ->sidebarCollapsibleOnDesktop()
        ->navigationGroups([
            'Content Management',
            'Store Management',
            'Order Management',
            'System Settings',
        ]);
}
```

#### Global Category Resource
```php
class GlobalCategoryResource extends Resource
{
    protected static ?string $model = GlobalCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Content Management';
    protected static ?int $navigationSort = 1;
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('name_ar')
                ->label('Name (Arabic)')
                ->maxLength(255),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\FileUpload::make('icon')
                ->image()
                ->directory('categories/icons'),
            Forms\Components\Textarea::make('description'),
            Forms\Components\Textarea::make('description_ar')
                ->label('Description (Arabic)'),
            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_active')
                ->default(true),
        ]);
    }
}
```


### 5.2 Merchant Panel Customization

#### Theme Configuration
```php
// app/Providers/Filament/MerchantPanelProvider.php

public function panel(Panel $panel): Panel
{
    return $panel
        ->id('merchant')
        ->path('merchant')
        ->brandName('SHOOFO Merchant')
        ->brandLogo(asset('images/logo-merchant.svg'))
        ->colors([
            'primary' => '#0A1628', // Deep Midnight Blue
            'secondary' => '#D4AF37', // Royal Gold
            'gray' => '#64748B',
        ])
        ->font('Inter')
        ->darkMode(false)
        ->maxContentWidth('7xl')
        ->sidebarCollapsibleOnDesktop()
        ->navigationGroups([
            'Store Management',
            'Product Management',
            'Order Management',
        ]);
}
```

#### Merchant Category Resource
```php
class MerchantCategoryResource extends Resource
{
    protected static ?string $model = MerchantCategory::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Store Management';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('global_category_id')
                ->label('Global Category')
                ->relationship('globalCategory', 'name')
                ->required()
                ->searchable(),
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->helperText('Custom name for your category'),
            Forms\Components\TextInput::make('name_ar')
                ->label('Name (Arabic)')
                ->maxLength(255),
            Forms\Components\TextInput::make('slug')
                ->required()
                ->unique(ignoreRecord: true),
            Forms\Components\Textarea::make('description'),
            Forms\Components\Textarea::make('description_ar'),
            Forms\Components\TextInput::make('order')
                ->numeric()
                ->default(0),
            Forms\Components\Toggle::make('is_active')
                ->default(true),
        ]);
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('merchant_id', auth()->user()->merchant->id);
    }
}
```


#### Product Resource (Merchant)
```php
class ProductResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Product Management';
    
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Basic Information')
                ->schema([
                    Forms\Components\Select::make('merchant_category_id')
                        ->label('Category')
                        ->relationship('merchantCategory', 'name', function($query) {
                            return $query->where('merchant_id', auth()->user()->merchant->id);
                        })
                        ->required()
                        ->searchable(),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('name_ar')
                        ->label('Name (Arabic)')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->unique(ignoreRecord: true),
                ]),
            
            Forms\Components\Section::make('Pricing & Inventory')
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->required()
                        ->numeric()
                        ->prefix('SAR'),
                    Forms\Components\TextInput::make('sale_price')
                        ->numeric()
                        ->prefix('SAR')
                        ->helperText('Leave empty if no sale'),
                    Forms\Components\TextInput::make('quantity')
                        ->required()
                        ->numeric()
                        ->default(0),
                    Forms\Components\TextInput::make('sku')
                        ->label('SKU')
                        ->maxLength(100),
                ])->columns(2),
            
            Forms\Components\Section::make('Description')
                ->schema([
                    Forms\Components\RichEditor::make('description')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('description_ar')
                        ->label('Description (Arabic)')
                        ->columnSpanFull(),
                ]),
            
            Forms\Components\Section::make('Images')
                ->schema([
                    Forms\Components\FileUpload::make('images')
                        ->multiple()
                        ->image()
                        ->directory('products')
                        ->maxFiles(10)
                        ->reorderable()
                        ->helperText('First image will be the primary image'),
                ]),
            
            Forms\Components\Section::make('Settings')
                ->schema([
                    Forms\Components\Toggle::make('is_active')
                        ->label('Active')
                        ->default(true),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Featured (Hero Product)')
                        ->helperText('Max 5 featured products per category'),
                    Forms\Components\TextInput::make('featured_order')
                        ->numeric()
                        ->visible(fn($get) => $get('is_featured')),
                ])->columns(3),
        ]);
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('merchant_id', auth()->user()->merchant->id);
    }
}
```

---

## 6. Localization Strategy

### 6.1 Language Files Structure

```
lang/
├── en/
│   ├── auth.php
│   ├── home.php
│   ├── products.php
│   ├── cart.php
│   └── orders.php
└── ar/
    ├── auth.php
    ├── home.php
    ├── products.php
    ├── cart.php
    └── orders.php
```

### 6.2 RTL Support

```css
/* resources/css/app.css */

[dir="rtl"] {
    direction: rtl;
    text-align: right;
}

[dir="rtl"] .ltr-content {
    direction: ltr;
    text-align: left;
}

/* Flip margins and paddings */
[dir="rtl"] .ml-4 { margin-right: 1rem; margin-left: 0; }
[dir="rtl"] .mr-4 { margin-left: 1rem; margin-right: 0; }
[dir="rtl"] .pl-4 { padding-right: 1rem; padding-left: 0; }
[dir="rtl"] .pr-4 { padding-left: 1rem; padding-right: 0; }
```

### 6.3 Language Switcher Component

```html
<!-- resources/views/components/language-switcher.blade.php -->
<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" class="flex items-center space-x-2">
        <span>{{ app()->getLocale() === 'ar' ? 'العربية' : 'English' }}</span>
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    
    <div x-show="open" 
         @click.away="open = false"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg">
        <a href="{{ route('locale.switch', 'en') }}" class="block px-4 py-2 hover:bg-gray-100">
            English
        </a>
        <a href="{{ route('locale.switch', 'ar') }}" class="block px-4 py-2 hover:bg-gray-100">
            العربية
        </a>
    </div>
</div>
```


---

## 7. Performance Optimization

### 7.1 Image Optimization

```php
// config/filesystems.php - Add image optimization

'image_driver' => 'gd', // or 'imagick'

// Use Intervention Image for optimization
public function optimizeImage($image)
{
    return Image::make($image)
        ->resize(1200, null, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })
        ->encode('webp', 85);
}
```

### 7.2 Caching Strategy

```php
// Cache global categories (rarely change)
$globalCategories = Cache::remember('global_categories', 3600, function() {
    return GlobalCategory::active()->get();
});

// Cache featured stores
$featuredStores = Cache::remember('featured_stores', 1800, function() {
    return Merchant::where('is_featured', true)
                  ->where('status', 'approved')
                  ->limit(6)
                  ->get();
});

// Cache product counts
$productCount = Cache::remember("merchant_{$merchantId}_product_count", 600, function() use ($merchantId) {
    return Product::where('merchant_id', $merchantId)->count();
});
```

### 7.3 Lazy Loading

```html
<!-- Lazy load images -->
<img src="{{ $product->primaryImage->url }}" 
     loading="lazy" 
     alt="{{ $product->name }}"
     class="w-full h-full object-cover">

<!-- Lazy load Alpine components -->
<div x-data="productGallery()" x-init="$nextTick(() => init())">
    <!-- Component content -->
</div>
```

### 7.4 Database Indexing

```php
// Already included in schema, but key indexes:
- products: merchant_id, merchant_category_id, is_active, is_featured
- merchant_categories: merchant_id, global_category_id, is_active
- orders: user_id, status, order_number
- cart_items: cart_id, product_id
```

---

## 8. Security Considerations

### 8.1 Input Validation

```php
// Product creation validation
$request->validate([
    'name' => 'required|string|max:255',
    'slug' => 'required|string|unique:products,slug,' . $product->id,
    'price' => 'required|numeric|min:0',
    'quantity' => 'required|integer|min:0',
    'merchant_category_id' => 'required|exists:merchant_categories,id',
    'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
]);
```

### 8.2 Authorization Policies

```php
// app/Policies/ProductPolicy.php
class ProductPolicy
{
    public function update(User $user, Product $product)
    {
        return $user->merchant && $user->merchant->id === $product->merchant_id;
    }
    
    public function delete(User $user, Product $product)
    {
        return $user->merchant && $user->merchant->id === $product->merchant_id;
    }
}
```

### 8.3 Rate Limiting

```php
// routes/web.php
Route::middleware(['throttle:60,1'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add']);
    Route::post('/orders', [OrderController::class, 'store']);
});
```

---

## 9. Testing Strategy

### 9.1 Feature Tests

```php
// tests/Feature/ProductTest.php
public function test_user_can_view_products_by_global_category()
{
    $globalCategory = GlobalCategory::factory()->create();
    $merchantCategory = MerchantCategory::factory()->create([
        'global_category_id' => $globalCategory->id
    ]);
    $product = Product::factory()->create([
        'merchant_category_id' => $merchantCategory->id
    ]);
    
    $response = $this->get(route('categories.show', $globalCategory->slug));
    
    $response->assertStatus(200);
    $response->assertSee($product->name);
}
```

### 9.2 Unit Tests

```php
// tests/Unit/ProductTest.php
public function test_product_returns_correct_current_price()
{
    $product = Product::factory()->create([
        'price' => 100,
        'sale_price' => 80
    ]);
    
    $this->assertEquals(80, $product->getCurrentPrice());
}
```

---

## 10. Deployment Checklist

### 10.1 Pre-Deployment

- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Run `npm run build`
- [ ] Set `APP_DEBUG=false`
- [ ] Set `APP_ENV=production`
- [ ] Configure proper database credentials
- [ ] Set up SSL certificate
- [ ] Configure email settings
- [ ] Set up backup strategy

### 10.2 Post-Deployment

- [ ] Run migrations: `php artisan migrate --force`
- [ ] Seed initial data: `php artisan db:seed`
- [ ] Test all critical paths
- [ ] Monitor error logs
- [ ] Set up monitoring (Laravel Telescope/Horizon)
- [ ] Configure CDN for static assets
- [ ] Set up queue workers
- [ ] Configure cron jobs

---

## 11. Future Enhancements

### Phase 2 Features
- Wishlist functionality
- Product reviews and ratings
- Advanced search with filters
- Store analytics dashboard
- Email marketing integration
- Social media sharing
- Live chat support

### Phase 3 Features
- Mobile app (React Native/Flutter)
- AR product preview
- AI-powered recommendations
- Multi-currency support
- Advanced shipping options
- Loyalty program
- Affiliate system

---

## Conclusion

This design document provides a comprehensive blueprint for building SHOOFO - a luxury smart marketplace that prioritizes prestige, elegance, and user experience. Every technical decision, from color choices to database schema, serves the ultimate goal of making merchants feel prestigious and customers feel amazed.

The combination of Laravel's robust backend, Tailwind's flexible styling, and Alpine.js's reactive components creates a solid foundation for a premium e-commerce experience that stands out from traditional marketplaces.

**Remember**: We're not building a website; we're building an experience. 🌟
