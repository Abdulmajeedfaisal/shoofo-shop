# Tasks Document: SHOOFO - Luxury Smart Marketplace

## Introduction

This document breaks down the implementation of SHOOFO into discrete, actionable tasks. Each task references specific requirements from `requirements.md` and design specifications from `design.md`.

**Task Notation:**
- Tasks marked with `*` are optional (testing, optimization)
- Tasks are grouped by feature area
- Dependencies are noted where applicable

---

## Phase 1: Foundation & Database

### Task 1.1: Create Global Categories Migration
**Requirements:** REQ-11  
**Design:** Section 4.2 Database Schema

Create migration for `global_categories` table with fields:
- id, name, name_ar, slug, icon, description, description_ar, order, is_active
- Add indexes: slug, order, is_active
- Add timestamps

**Files to create:**
- `database/migrations/YYYY_MM_DD_create_global_categories_table.php`

---

### Task 1.2: Create Merchant Categories Migration
**Requirements:** REQ-6, REQ-11  
**Design:** Section 4.2 Database Schema

Create migration for `merchant_categories` table with fields:
- id, merchant_id, global_category_id, name, name_ar, slug, description, description_ar, order, is_active
- Foreign keys: merchant_id → merchants, global_category_id → global_categories
- Unique constraint: (merchant_id, slug)
- Add indexes: merchant_id, global_category_id, is_active

**Files to create:**
- `database/migrations/YYYY_MM_DD_create_merchant_categories_table.php`

---

### Task 1.3: Update Products Table Migration
**Requirements:** REQ-6, REQ-8  
**Design:** Section 4.2 Database Schema

Modify existing products table:
- Replace `category_id` with `merchant_category_id`
- Add `is_featured` boolean field (default false)
- Add `featured_order` integer field (nullable)
- Update foreign key to reference merchant_categories
- Add indexes: merchant_category_id, is_featured

**Files to modify:**
- `database/migrations/2026_01_04_033841_create_products_table.php`

---

### Task 1.4: Create Carts Table Migration
**Requirements:** REQ-9  
**Design:** Section 4.2 Database Schema

Create migration for `carts` table with fields:
- id, user_id, timestamps
- Foreign key: user_id → users
- Unique constraint: user_id

**Files to create:**
- `database/migrations/YYYY_MM_DD_create_carts_table.php`

---

### Task 1.5: Create Cart Items Table Migration
**Requirements:** REQ-9  
**Design:** Section 4.2 Database Schema

Create migration for `cart_items` table with fields:
- id, cart_id, product_id, quantity, price, timestamps
- Foreign keys: cart_id → carts, product_id → products
- Unique constraint: (cart_id, product_id)

**Files to create:**
- `database/migrations/YYYY_MM_DD_create_cart_items_table.php`

---

### Task 1.6: Create Orders Table Migration
**Requirements:** REQ-10  
**Design:** Section 4.2 Database Schema

Create migration for `orders` table with fields:
- id, user_id, order_number, status, subtotal, tax, shipping, total
- Shipping info: name, email, phone, address, city, country, postal_code
- Payment info: payment_method, payment_status
- notes, timestamps
- Foreign key: user_id → users
- Indexes: user_id, status, order_number

**Files to create:**
- `database/migrations/YYYY_MM_DD_create_orders_table.php`

---

### Task 1.7: Create Order Items Table Migration
**Requirements:** REQ-10  
**Design:** Section 4.2 Database Schema

Create migration for `order_items` table with fields:
- id, order_id, product_id, merchant_id, product_name, product_name_ar, quantity, price, subtotal, timestamps
- Foreign keys: order_id → orders, product_id → products, merchant_id → merchants
- Indexes: order_id, merchant_id

**Files to create:**
- `database/migrations/YYYY_MM_DD_create_order_items_table.php`

---

### Task 1.8: Run Migrations Checkpoint
**Requirements:** All database requirements  
**Design:** Section 4.2

Run all migrations and verify database schema:
```bash
php artisan migrate:fresh
```

Verify all tables created correctly with proper relationships and indexes.

---

## Phase 2: Models & Relationships

### Task 2.1: Create GlobalCategory Model
**Requirements:** REQ-11  
**Design:** Section 4.3 Key Models

Create GlobalCategory model with:
- Fillable fields: name, name_ar, slug, icon, description, description_ar, order, is_active
- Cast: is_active → boolean
- Relationship: hasMany(MerchantCategory)
- Scope: active() - filters active categories ordered by order field

**Files to create:**
- `app/Models/GlobalCategory.php`

---

### Task 2.2: Create MerchantCategory Model
**Requirements:** REQ-6, REQ-11  
**Design:** Section 4.3 Key Models

Create MerchantCategory model with:
- Fillable fields: merchant_id, global_category_id, name, name_ar, slug, description, description_ar, order, is_active
- Cast: is_active → boolean
- Relationships: belongsTo(Merchant), belongsTo(GlobalCategory), hasMany(Product), featuredProducts()
- Scope: active() - filters active categories ordered by order field

**Files to create:**
- `app/Models/MerchantCategory.php`

---

### Task 2.3: Update Product Model
**Requirements:** REQ-6, REQ-7, REQ-8  
**Design:** Section 4.3 Key Models

Update existing Product model:
- Add to fillable: merchant_category_id, is_featured, featured_order
- Add casts: is_featured → boolean
- Update relationship: merchantCategory() belongsTo(MerchantCategory)
- Add method: globalCategory() - returns global category through merchant category
- Add method: getCurrentPrice() - returns sale_price if exists, else price
- Add method: isInStock() - returns quantity > 0
- Add scope: featured() - filters featured products ordered by featured_order
- Add scope: byGlobalCategory($globalCategoryId) - filters by global category through merchant category

**Files to modify:**
- `app/Models/Product.php`

---

### Task 2.4: Update Merchant Model
**Requirements:** REQ-3, REQ-5, REQ-14  
**Design:** Section 4.3

Update existing Merchant model:
- Add relationship: hasMany(MerchantCategory)
- Add relationship: hasMany(Product)
- Add scope: approved() - filters merchants with status 'approved'
- Add scope: featured() - filters featured merchants

**Files to modify:**
- `app/Models/Merchant.php`

---

### Task 2.5: Create Cart Model
**Requirements:** REQ-9  
**Design:** Section 4.3

Create Cart model with:
- Relationship: belongsTo(User)
- Relationship: hasMany(CartItem)
- Method: getTotalAmount() - calculates total of all cart items

**Files to create:**
- `app/Models/Cart.php`

---

### Task 2.6: Create CartItem Model
**Requirements:** REQ-9  
**Design:** Section 4.3

Create CartItem model with:
- Fillable: cart_id, product_id, quantity, price
- Relationship: belongsTo(Cart)
- Relationship: belongsTo(Product)
- Method: getSubtotal() - returns quantity * price

**Files to create:**
- `app/Models/CartItem.php`

---

### Task 2.7: Create Order Model
**Requirements:** REQ-10  
**Design:** Section 4.3

Create Order model with:
- Fillable: user_id, order_number, status, subtotal, tax, shipping, total, shipping_*, payment_*, notes
- Casts: subtotal, tax, shipping, total → decimal:2
- Relationship: belongsTo(User)
- Relationship: hasMany(OrderItem)
- Method: generateOrderNumber() - generates unique order number
- Scope: byStatus($status)

**Files to create:**
- `app/Models/Order.php`

---

### Task 2.8: Create OrderItem Model
**Requirements:** REQ-10  
**Design:** Section 4.3

Create OrderItem model with:
- Fillable: order_id, product_id, merchant_id, product_name, product_name_ar, quantity, price, subtotal
- Casts: price, subtotal → decimal:2
- Relationship: belongsTo(Order)
- Relationship: belongsTo(Product)
- Relationship: belongsTo(Merchant)

**Files to create:**
- `app/Models/OrderItem.php`

---

### Task 2.9: Update User Model
**Requirements:** REQ-9, REQ-10, REQ-17  
**Design:** Section 4.3

Update existing User model:
- Add relationship: hasOne(Cart)
- Add relationship: hasMany(Order)
- Add method: getOrCreateCart() - returns existing cart or creates new one

**Files to modify:**
- `app/Models/User.php`

---

## Phase 3: Design System & Assets

### Task 3.1: Configure Tailwind with Luxury Design System
**Requirements:** REQ-1, REQ-18  
**Design:** Section 1 Visual Design System

Update Tailwind configuration with:
- Custom colors: midnight, royal-gold, rose-gold, silver, charcoal, slate
- Custom fonts: Playfair Display, Inter, Cormorant Garamond
- Custom spacing scale (xs to 5xl)
- Custom shadows (sm to 2xl)
- Custom border radius
- RTL support configuration

**Files to modify:**
- `tailwind.config.js`

---

### Task 3.2: Add Google Fonts
**Requirements:** REQ-1  
**Design:** Section 1.2 Typography

Add Google Fonts to layout:
- Playfair Display (weights: 400, 600, 700)
- Inter (weights: 300, 400, 500, 600)
- Cormorant Garamond (weights: 400, 600)

**Files to modify:**
- `resources/views/layouts/app.blade.php`

---

### Task 3.3: Create Base CSS with Animations
**Requirements:** REQ-1, REQ-19  
**Design:** Section 1.6 Animation & Transitions

Create custom CSS file with:
- Animation timing functions (ease-smooth, ease-elegant, ease-bounce)
- Transition utilities
- RTL support styles
- Base typography styles

**Files to create:**
- `resources/css/luxury.css`

**Files to modify:**
- `resources/css/app.css` (import luxury.css)

---

### Task 3.4: Create Reusable Blade Components
**Requirements:** REQ-1, REQ-18  
**Design:** Section 2 Component Design System

Create Blade components:
- `button.blade.php` (primary, secondary, ghost variants)
- `card.blade.php` (product, store variants)
- `input.blade.php` (text, select, checkbox, radio)
- `language-switcher.blade.php`

**Files to create:**
- `resources/views/components/button.blade.php`
- `resources/views/components/card.blade.php`
- `resources/views/components/input.blade.php`
- `resources/views/components/language-switcher.blade.php`

---

## Phase 4: Localization Setup

### Task 4.1: Configure Localization
**Requirements:** REQ-15  
**Design:** Section 6 Localization Strategy

Configure Laravel localization:
- Set supported locales: en, ar
- Set default locale: en
- Set fallback locale: en

**Files to modify:**
- `config/app.php`

---

### Task 4.2: Create Language Files
**Requirements:** REQ-15  
**Design:** Section 6.1

Create language files for both English and Arabic:
- auth.php (login, register, password reset)
- home.php (landing page content)
- products.php (product-related text)
- cart.php (cart and checkout)
- orders.php (order-related text)
- navigation.php (menu items)

**Files to create:**
- `lang/en/*.php` (6 files)
- `lang/ar/*.php` (6 files)

---

### Task 4.3: Create Locale Switching Route & Middleware
**Requirements:** REQ-15  
**Design:** Section 6.3

Create route for switching locale and middleware to set locale from session/user preference.

**Files to create:**
- `app/Http/Middleware/SetLocale.php`

**Files to modify:**
- `routes/web.php` (add locale.switch route)
- `app/Http/Kernel.php` (register middleware)

---

## Phase 5: Frontend - Landing Page

### Task 5.1: Create HomeController
**Requirements:** REQ-1  
**Design:** Section 4.4 Key Controllers

Create HomeController with index() method that:
- Fetches active banners ordered by priority
- Fetches active global categories
- Fetches featured stores (approved, limit 6)
- Returns home view with data

**Files to create:**
- `app/Http/Controllers/HomeController.php`

**Files to modify:**
- `routes/web.php` (add home route)

---

### Task 5.2: Create Landing Page View
**Requirements:** REQ-1  
**Design:** Section 3.1 Landing Page

Create home.blade.php with:
- Hero section with cinematic banner slider
- Global categories section with elegant cards
- Featured stores section
- Smooth scroll animations
- Responsive grid layouts

**Files to create:**
- `resources/views/home.blade.php`

---

### Task 5.3: Create Banner Slider Component (Alpine.js)
**Requirements:** REQ-1  
**Design:** Section 3.1 Hero Section

Create Alpine.js component for banner slider:
- Auto-play with 5-second intervals
- Smooth fade transitions (1000ms)
- Navigation dots
- Swipe support for mobile
- Pause on hover

**Files to create:**
- `resources/js/components/banner-slider.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

### Task 5.4: Style Global Categories Cards
**Requirements:** REQ-1, REQ-2  
**Design:** Section 3.1 Global Categories Section

Style category cards with:
- Large icons (80px x 80px)
- Bilingual names
- Hover effects (scale, shadow)
- Responsive grid (4 cols desktop, 2 tablet, 1 mobile)
- Generous spacing

**Files to modify:**
- `resources/views/home.blade.php`

---

### Task 5.5: Style Featured Stores Section
**Requirements:** REQ-1, REQ-3  
**Design:** Section 3.1 Featured Stores Section

Style store cards with:
- Store logo (120px x 120px, circular)
- Store name (H3, Playfair Display)
- Description (3 lines max)
- CTA button
- Hover effects (shadow, translateY)
- Responsive grid (3 cols desktop, 2 tablet, 1 mobile)

**Files to modify:**
- `resources/views/home.blade.php`

---

## Phase 6: Frontend - Global Category Pages

### Task 6.1: Create GlobalCategoryController
**Requirements:** REQ-2  
**Design:** Section 4.4 Key Controllers

Create GlobalCategoryController with show() method that:
- Finds global category by slug
- Fetches all products linked to this global category (through merchant categories)
- Eager loads: merchant, merchantCategory, primaryImage
- Paginates results (24 per page)
- Returns category view

**Files to create:**
- `app/Http/Controllers/GlobalCategoryController.php`

**Files to modify:**
- `routes/web.php` (add category route)

---

### Task 6.2: Create Global Category View
**Requirements:** REQ-2, REQ-7  
**Design:** Section 3 Page-Specific Designs

Create categories/show.blade.php with:
- Category header (name, description)
- Products grid with store branding
- Product cards showing: image, store logo badge, store name, product name, price, merchant category
- Hover effects
- Pagination
- Empty state

**Files to create:**
- `resources/views/categories/show.blade.php`

---

### Task 6.3: Create Product Card Component (Global View)
**Requirements:** REQ-7  
**Design:** Section 2.2 Cards - Product Card

Create product-card.blade.php component with:
- Product image (4:3 aspect ratio)
- Store logo badge (top-right, 40px, circular)
- Store name (small, gray)
- Product name (H5, 2 lines max)
- Price (H4, royal gold)
- Merchant category name (caption, gray)
- Hover effects (shadow-xl, scale 1.02)
- Click to product detail page

**Files to create:**
- `resources/views/components/product-card.blade.php`

---

## Phase 7: Frontend - Store Directory & Pages

### Task 7.1: Create StoreController
**Requirements:** REQ-3, REQ-5  
**Design:** Section 4.4 Key Controllers

Create StoreController with:
- index() method: Lists all approved stores with pagination
- show() method: Shows single store with categories and products

**Files to create:**
- `app/Http/Controllers/StoreController.php`

**Files to modify:**
- `routes/web.php` (add stores routes)

---

### Task 7.2: Create Store Directory View
**Requirements:** REQ-3  
**Design:** Section 3 Page-Specific Designs

Create stores/index.blade.php with:
- Page header
- Store cards grid (3 cols desktop, 2 tablet, 1 mobile)
- Store card: logo, name, description, CTA
- Hover effects
- Pagination
- Empty state

**Files to create:**
- `resources/views/stores/index.blade.php`

---

### Task 7.3: Create Store Entrance Animation Component
**Requirements:** REQ-4  
**Design:** Section 3.2 Store Entrance Animation

Create Alpine.js component for store entrance animation:
- 2-3 second animation sequence
- Fade out → Show logo (center, bounce) → Fade to store page
- Click anywhere to skip
- Smooth transitions with custom easing

**Files to create:**
- `resources/js/components/store-entrance.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

### Task 7.4: Create Store Page View
**Requirements:** REQ-5, REQ-6  
**Design:** Section 3.3 Store Page Layout

Create stores/show.blade.php with:
- Store entrance animation wrapper
- Store header: logo (150px), name (H1), description
- Category tabs (sticky below nav)
- Products grid
- Featured products displayed first (larger cards)
- Filter by merchant category
- Empty state

**Files to create:**
- `resources/views/stores/show.blade.php`

---

### Task 7.5: Create Product Card Component (Store View)
**Requirements:** REQ-5  
**Design:** Section 2.2 Cards

Create product-card-store.blade.php component (similar to global view but without store branding):
- Product image
- Product name
- Price (with sale price if exists)
- Merchant category name
- Featured badge if is_featured
- Hover effects

**Files to create:**
- `resources/views/components/product-card-store.blade.php`

---

### Task 7.6: Implement Category Filtering (Alpine.js)
**Requirements:** REQ-5, REQ-6  
**Design:** Section 3.3 Store Page

Create Alpine.js component for filtering products by merchant category:
- Tab navigation
- Show all products or filter by category
- Smooth transitions
- Update URL without page reload

**Files to create:**
- `resources/js/components/category-filter.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

## Phase 8: Frontend - Product Detail Page

### Task 8.1: Create ProductController
**Requirements:** REQ-8  
**Design:** Section 4.4 Key Controllers

Create ProductController with show() method that:
- Finds merchant by slug
- Finds product by slug and merchant_id
- Eager loads: images, merchantCategory, merchant
- Increments views_count
- Returns product view

**Files to create:**
- `app/Http/Controllers/ProductController.php`

**Files to modify:**
- `routes/web.php` (add product route: /stores/{merchant}/products/{product})

---

### Task 8.2: Create Product Detail View
**Requirements:** REQ-8  
**Design:** Section 3.4 Product Detail Page

Create products/show.blade.php with:
- Two-column layout (image gallery | details)
- Breadcrumb navigation
- Store badge (logo + name, clickable with entrance animation)
- Image gallery with thumbnails
- Product details: name, price, sale price, category, description
- Quantity selector
- Add to Cart button (requires auth)
- Wishlist button (ghost)
- Responsive layout

**Files to create:**
- `resources/views/products/show.blade.php`

---

### Task 8.3: Create Image Gallery Component (Alpine.js)
**Requirements:** REQ-8  
**Design:** Section 3.4 Product Detail Page

Create Alpine.js component for product image gallery:
- Main image display (600px x 600px)
- Thumbnail navigation (80px x 80px each)
- Click thumbnail to change main image
- Click main image to open lightbox
- Hover to zoom
- Smooth transitions

**Files to create:**
- `resources/js/components/image-gallery.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

### Task 8.4: Create Quantity Selector Component
**Requirements:** REQ-8, REQ-9  
**Design:** Section 3.4 Product Detail Page

Create Alpine.js component for quantity selector:
- Plus/minus buttons
- Input field (read-only)
- Min: 1, Max: product.quantity
- Elegant styling

**Files to create:**
- `resources/js/components/quantity-selector.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

## Phase 9: Shopping Cart System

### Task 9.1: Create CartController
**Requirements:** REQ-9  
**Design:** Section 4.4 Key Controllers

Create CartController with methods:
- index(): Display cart
- add(): Add product to cart (requires auth)
- update(): Update cart item quantity
- remove(): Remove cart item

**Files to create:**
- `app/Http/Controllers/CartController.php`

**Files to modify:**
- `routes/web.php` (add cart routes)

---

### Task 9.2: Create Cart View
**Requirements:** REQ-9  
**Design:** Section 3 Page-Specific Designs

Create cart/index.blade.php with:
- Cart items list (image, name, price, quantity selector, subtotal, remove button)
- Cart summary (subtotal, tax, total)
- Proceed to Checkout button
- Continue Shopping link
- Empty cart state
- Responsive layout

**Files to create:**
- `resources/views/cart/index.blade.php`

---

### Task 9.3: Create Cart Icon Component (Navigation)
**Requirements:** REQ-9  
**Design:** Section 2.3 Navigation

Create cart icon component for navigation:
- Cart icon with badge showing item count
- Alpine.js reactive update when items added
- Link to cart page
- Elegant styling

**Files to create:**
- `resources/views/components/cart-icon.blade.php`

**Files to modify:**
- `resources/views/layouts/app.blade.php` (add to navigation)

---

### Task 9.4: Implement Add to Cart Functionality
**Requirements:** REQ-9  
**Design:** Section 4.4 CartController

Implement add to cart logic:
- Check authentication (redirect to login if not authenticated)
- Get or create user's cart
- Add or update cart item
- Store current product price
- Show success notification
- Update cart icon badge

**Files to modify:**
- `app/Http/Controllers/CartController.php`

---

### Task 9.5: Create Cart Update/Remove with Alpine.js
**Requirements:** REQ-9  
**Design:** Section 3 Page-Specific Designs

Create Alpine.js component for cart management:
- Update quantity with AJAX
- Remove item with confirmation
- Real-time total calculation
- Smooth animations
- Loading states

**Files to create:**
- `resources/js/components/cart-manager.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

## Phase 10: Checkout & Orders

### Task 10.1: Create OrderController
**Requirements:** REQ-10  
**Design:** Section 4.4 Key Controllers

Create OrderController with methods:
- create(): Show checkout form
- store(): Process order
- show(): Display order details
- index(): List user's orders

**Files to create:**
- `app/Http/Controllers/OrderController.php`

**Files to modify:**
- `routes/web.php` (add order routes)

---

### Task 10.2: Create Checkout View
**Requirements:** REQ-10  
**Design:** Section 3 Page-Specific Designs

Create orders/create.blade.php with:
- Multi-step form (Shipping, Payment, Review)
- Step indicators
- Shipping address form
- Payment method selection
- Order summary
- Terms & conditions checkbox
- Place Order button
- Form validation
- Responsive layout

**Files to create:**
- `resources/views/orders/create.blade.php`

---

### Task 10.3: Create Multi-Step Checkout Component (Alpine.js)
**Requirements:** REQ-10  
**Design:** Section 3 Page-Specific Designs

Create Alpine.js component for multi-step checkout:
- Step navigation
- Form validation per step
- Progress indicator
- Next/Previous buttons
- Smooth transitions between steps

**Files to create:**
- `resources/js/components/checkout-steps.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

### Task 10.4: Implement Order Processing Logic
**Requirements:** REQ-10, REQ-20  
**Design:** Section 4.4 OrderController

Implement order creation logic:
- Validate checkout form
- Generate unique order number
- Create order record
- Create order items from cart
- Clear user's cart
- Send notifications (customer, merchants)
- Redirect to order confirmation

**Files to modify:**
- `app/Http/Controllers/OrderController.php`

---

### Task 10.5: Create Order Confirmation View
**Requirements:** REQ-10  
**Design:** Section 3 Page-Specific Designs

Create orders/show.blade.php with:
- Order number
- Order status
- Order items list
- Shipping address
- Payment method
- Order totals
- Estimated delivery
- Track order button
- Elegant styling

**Files to create:**
- `resources/views/orders/show.blade.php`

---

### Task 10.6: Create Order History View
**Requirements:** REQ-17  
**Design:** Section 3 Page-Specific Designs

Create orders/index.blade.php with:
- List of user's orders
- Order cards: order number, date, status, total, items count
- Click to view order details
- Filter by status
- Pagination
- Empty state

**Files to create:**
- `resources/views/orders/index.blade.php`

---

## Phase 11: Admin Panel - Filament Resources

### Task 11.1: Customize Admin Panel Theme
**Requirements:** REQ-13  
**Design:** Section 5.1 Admin Panel Customization

Customize Filament admin panel:
- Brand name: "SHOOFO Admin"
- Brand logo
- Colors: primary (Royal Gold), gray, success, danger
- Font: Inter
- Navigation groups: Content Management, Store Management, Order Management, System Settings

**Files to modify:**
- `app/Providers/Filament/AdminPanelProvider.php`

---

### Task 11.2: Create GlobalCategoryResource (Admin)
**Requirements:** REQ-11  
**Design:** Section 5.1 Admin Panel

Create Filament resource for GlobalCategory:
- Form fields: name, name_ar, slug, icon (file upload), description, description_ar, order, is_active
- Table columns: name, name_ar, order, is_active, merchant_categories_count
- Filters: is_active
- Actions: edit, delete (with validation - prevent if linked)
- Bulk actions: activate, deactivate
- Reorderable

**Files to create:**
- `app/Filament/Resources/GlobalCategoryResource.php`
- `app/Filament/Resources/GlobalCategoryResource/Pages/*.php`

---

### Task 11.3: Create BannerResource (Admin)
**Requirements:** REQ-1, REQ-13  
**Design:** Section 5.1 Admin Panel

Create Filament resource for Banner:
- Form fields: title, title_ar, image, link, start_date, end_date, order, is_active
- Table columns: title, image (preview), order, is_active, date_range
- Filters: is_active, date_range
- Actions: edit, delete
- Bulk actions: activate, deactivate
- Reorderable

**Files to create:**
- `app/Filament/Resources/BannerResource.php`
- `app/Filament/Resources/BannerResource/Pages/*.php`

---

### Task 11.4: Create MerchantResource (Admin)
**Requirements:** REQ-13, REQ-14  
**Design:** Section 5.1 Admin Panel

Create Filament resource for Merchant:
- Table columns: store_name, user.name, user.email, status, created_at
- Filters: status (pending, approved, rejected)
- Actions: approve, reject, view, edit
- Bulk actions: approve, reject
- Custom actions with notifications

**Files to modify:**
- `app/Filament/Resources/MerchantResource.php` (if exists, else create)
- `app/Filament/Resources/MerchantResource/Pages/*.php`

---

### Task 11.5: Create OrderResource (Admin)
**Requirements:** REQ-13  
**Design:** Section 5.1 Admin Panel

Create Filament resource for Order:
- Table columns: order_number, user.name, status, total, created_at
- Filters: status, date_range
- Actions: view, update_status
- Relation managers: OrderItems
- Custom page: Order details with items

**Files to create:**
- `app/Filament/Resources/OrderResource.php`
- `app/Filament/Resources/OrderResource/Pages/*.php`
- `app/Filament/Resources/OrderResource/RelationManagers/OrderItemsRelationManager.php`

---

### Task 11.6: Create UserResource (Admin)
**Requirements:** REQ-13  
**Design:** Section 5.1 Admin Panel

Create Filament resource for User:
- Table columns: name, email, role, created_at
- Filters: role
- Actions: edit, delete (with validation)
- Form fields: name, email, password, role

**Files to create:**
- `app/Filament/Resources/UserResource.php`
- `app/Filament/Resources/UserResource/Pages/*.php`

---

## Phase 12: Merchant Panel - Filament Resources

### Task 12.1: Customize Merchant Panel Theme
**Requirements:** REQ-12  
**Design:** Section 5.2 Merchant Panel Customization

Customize Filament merchant panel:
- Brand name: "SHOOFO Merchant"
- Brand logo
- Colors: primary (Deep Midnight Blue), secondary (Royal Gold), gray
- Font: Inter
- Elegant, minimalist design
- Navigation groups: Store Management, Product Management, Order Management

**Files to modify:**
- `app/Providers/Filament/MerchantPanelProvider.php`

---

### Task 12.2: Create MerchantCategoryResource (Merchant)
**Requirements:** REQ-6, REQ-12  
**Design:** Section 5.2 Merchant Panel

Create Filament resource for MerchantCategory (merchant panel):
- Form fields: global_category_id (select), name, name_ar, slug, description, description_ar, order, is_active
- Table columns: name, name_ar, global_category.name, products_count, is_active
- Filters: global_category, is_active
- Actions: edit, delete (with validation - prevent if products exist)
- Scope: Only show current merchant's categories
- Reorderable

**Files to create:**
- `app/Filament/Merchant/Resources/MerchantCategoryResource.php`
- `app/Filament/Merchant/Resources/MerchantCategoryResource/Pages/*.php`

---

### Task 12.3: Create ProductResource (Merchant)
**Requirements:** REQ-6, REQ-12  
**Design:** Section 5.2 Merchant Panel - Product Resource

Create Filament resource for Product (merchant panel):
- Form sections: Basic Information, Pricing & Inventory, Description, Images, Settings
- Form fields: merchant_category_id, name, name_ar, slug, price, sale_price, quantity, sku, description, description_ar, images (multiple upload), is_active, is_featured, featured_order
- Table columns: image, name, merchant_category.name, price, quantity, is_featured, is_active
- Filters: merchant_category, is_active, is_featured
- Actions: edit, delete, duplicate
- Bulk actions: activate, deactivate, feature, unfeature
- Scope: Only show current merchant's products
- Validation: Max 5 featured products per category

**Files to modify:**
- `app/Filament/Merchant/Resources/ProductResource.php` (if exists, else create)
- `app/Filament/Merchant/Resources/ProductResource/Pages/*.php`

---

### Task 12.4: Create OrderResource (Merchant)
**Requirements:** REQ-12  
**Design:** Section 5.2 Merchant Panel

Create Filament resource for Order (merchant panel):
- Table columns: order_number, customer_name, status, items_count, total, created_at
- Filters: status, date_range
- Actions: view, update_status
- Scope: Only show orders containing merchant's products
- Custom page: Order details with merchant's items only
- Status update with customer notification

**Files to create:**
- `app/Filament/Merchant/Resources/OrderResource.php`
- `app/Filament/Merchant/Resources/OrderResource/Pages/*.php`

---

### Task 12.5: Create Merchant Dashboard Widgets
**Requirements:** REQ-12  
**Design:** Section 5.2 Merchant Panel

Create dashboard widgets for merchant panel:
- Total products count
- Total orders count
- Total revenue
- Recent orders list
- Low stock products alert
- Elegant, refined styling

**Files to create:**
- `app/Filament/Merchant/Widgets/StatsOverview.php`
- `app/Filament/Merchant/Widgets/RecentOrders.php`
- `app/Filament/Merchant/Widgets/LowStockProducts.php`

---

## Phase 13: Authentication & Authorization

### Task 13.1: Update Registration to Support Merchant Role
**Requirements:** REQ-14  
**Design:** Section 4 Technical Architecture

Update registration form and logic:
- Add role selection (customer/merchant)
- If merchant: Add store info fields (store_name, store_description, store_phone)
- Create merchant profile with status "pending" after registration
- Send notification to admins

**Files to modify:**
- `resources/views/auth/register.blade.php`
- `app/Http/Controllers/Auth/RegisteredUserController.php`

---

### Task 13.2: Create Merchant Approval Middleware
**Requirements:** REQ-14  
**Design:** Section 4 Technical Architecture

Create middleware to check merchant approval status:
- Allow access to merchant panel only if status is "approved"
- Redirect to "pending approval" page if status is "pending"
- Redirect to "rejected" page if status is "rejected"

**Files to create:**
- `app/Http/Middleware/EnsureMerchantApproved.php`

**Files to modify:**
- `app/Http/Kernel.php` (register middleware)
- `app/Providers/Filament/MerchantPanelProvider.php` (apply middleware)

---

### Task 13.3: Create Pending Approval View
**Requirements:** REQ-14  
**Design:** Section 3 Page-Specific Designs

Create view for pending merchants:
- Elegant message explaining approval process
- Contact support link
- Logout button
- Refined styling

**Files to create:**
- `resources/views/merchant/pending.blade.php`

---

### Task 13.4: Create Product Policy
**Requirements:** REQ-21  
**Design:** Section 8.2 Authorization Policies

Create policy for Product model:
- viewAny: Merchant can view only their products
- create: Merchant can create products
- update: Merchant can update only their products
- delete: Merchant can delete only their products

**Files to create:**
- `app/Policies/ProductPolicy.php`

**Files to modify:**
- `app/Providers/AuthServiceProvider.php` (register policy)

---

### Task 13.5: Create MerchantCategory Policy
**Requirements:** REQ-21  
**Design:** Section 8.2 Authorization Policies

Create policy for MerchantCategory model:
- viewAny: Merchant can view only their categories
- create: Merchant can create categories
- update: Merchant can update only their categories
- delete: Merchant can delete only their categories (if no products)

**Files to create:**
- `app/Policies/MerchantCategoryPolicy.php`

**Files to modify:**
- `app/Providers/AuthServiceProvider.php` (register policy)

---

### Task 13.6: Implement Smart Login Redirect
**Requirements:** REQ-1, REQ-12, REQ-13  
**Design:** Section 4 Technical Architecture

Update login logic to redirect users based on role:
- Admin → /admin
- Merchant (approved) → /merchant
- Merchant (pending) → /merchant/pending
- Customer → / (home)

**Files to modify:**
- `app/Http/Controllers/Auth/AuthenticatedSessionController.php`

---

## Phase 14: Notifications System

### Task 14.1: Create Order Notification
**Requirements:** REQ-20  
**Design:** Section 4 Technical Architecture

Create notification for order placed:
- Send to customer: Order confirmation with details
- Send to merchant(s): New order notification
- Email template with elegant styling

**Files to create:**
- `app/Notifications/OrderPlaced.php`
- `resources/views/emails/orders/placed.blade.php`

---

### Task 14.2: Create Merchant Approval Notifications
**Requirements:** REQ-14, REQ-20  
**Design:** Section 4 Technical Architecture

Create notifications for merchant approval:
- MerchantApproved: Welcome message with next steps
- MerchantRejected: Rejection message with reason
- NewMerchantRegistered: Notify admins of new merchant

**Files to create:**
- `app/Notifications/MerchantApproved.php`
- `app/Notifications/MerchantRejected.php`
- `app/Notifications/NewMerchantRegistered.php`
- `resources/views/emails/merchants/*.blade.php`

---

### Task 14.3: Create Order Status Update Notification
**Requirements:** REQ-20  
**Design:** Section 4 Technical Architecture

Create notification for order status changes:
- Send to customer when merchant/admin updates order status
- Email template with order details and new status

**Files to create:**
- `app/Notifications/OrderStatusUpdated.php`
- `resources/views/emails/orders/status-updated.blade.php`

---

### Task 14.4: Implement In-App Notifications (Optional)*
**Requirements:** REQ-20  
**Design:** Section 4 Technical Architecture

Create in-app notification system:
- Notification icon in navigation with badge
- Dropdown showing recent notifications
- Mark as read functionality
- Link to relevant pages

**Files to create:**
- `resources/views/components/notifications-dropdown.blade.php`
- `resources/js/components/notifications.js`

**Files to modify:**
- `resources/views/layouts/app.blade.php` (add to navigation)

---

## Phase 15: Search & Filtering

### Task 15.1: Create SearchController
**Requirements:** REQ-16  
**Design:** Section 4.4 Key Controllers

Create SearchController with search() method:
- Search products by name and description
- Filter by global category
- Filter by price range
- Filter by store
- Combine filters with AND logic
- Paginate results

**Files to create:**
- `app/Http/Controllers/SearchController.php`

**Files to modify:**
- `routes/web.php` (add search route)

---

### Task 15.2: Create Search View
**Requirements:** REQ-16  
**Design:** Section 3 Page-Specific Designs

Create search/index.blade.php with:
- Search query display
- Filter sidebar (categories, price range, stores)
- Products grid
- Results count
- Pagination
- Empty state

**Files to create:**
- `resources/views/search/index.blade.php`

---

### Task 15.3: Create Search Bar Component
**Requirements:** REQ-16  
**Design:** Section 2.3 Navigation

Create search bar component for navigation:
- Search input with icon
- Submit on enter or click
- Elegant styling
- Responsive (collapse to icon on mobile)

**Files to create:**
- `resources/views/components/search-bar.blade.php`

**Files to modify:**
- `resources/views/layouts/app.blade.php` (add to navigation)

---

### Task 15.4: Implement Real-Time Filter Updates (Alpine.js)
**Requirements:** REQ-16  
**Design:** Section 3 Page-Specific Designs

Create Alpine.js component for real-time filtering:
- Update results without page reload
- Update URL with filter parameters
- Loading states
- Smooth transitions

**Files to create:**
- `resources/js/components/search-filters.js`

**Files to modify:**
- `resources/js/app.js` (import component)

---

## Phase 16: User Profile Management

### Task 16.1: Create ProfileController
**Requirements:** REQ-17  
**Design:** Section 4.4 Key Controllers

Create ProfileController with methods:
- edit(): Show profile form
- update(): Update profile
- updatePassword(): Update password

**Files to create:**
- `app/Http/Controllers/ProfileController.php`

**Files to modify:**
- `routes/web.php` (add profile routes)

---

### Task 16.2: Create Profile View
**Requirements:** REQ-17  
**Design:** Section 3 Page-Specific Designs

Create profile/edit.blade.php with:
- Profile information form (name, email, phone)
- Password change form
- Shipping addresses management
- Order history link
- Elegant, organized layout

**Files to create:**
- `resources/views/profile/edit.blade.php`

---

## Phase 17: Performance Optimization

### Task 17.1: Implement Image Optimization
**Requirements:** REQ-19  
**Design:** Section 7.1 Image Optimization

Implement image optimization:
- Install Intervention Image package
- Create image optimization helper
- Resize images on upload (max 1200px width)
- Convert to WebP format
- Generate thumbnails

**Files to create:**
- `app/Helpers/ImageHelper.php`

**Files to modify:**
- `composer.json` (add intervention/image)
- Product upload logic in controllers/resources

---

### Task 17.2: Implement Caching Strategy
**Requirements:** REQ-19  
**Design:** Section 7.2 Caching Strategy

Implement caching for frequently accessed data:
- Cache global categories (1 hour)
- Cache featured stores (30 minutes)
- Cache product counts (10 minutes)
- Clear cache on updates

**Files to modify:**
- `app/Http/Controllers/HomeController.php`
- `app/Http/Controllers/GlobalCategoryController.php`
- Model observers for cache invalidation

---

### Task 17.3: Implement Lazy Loading
**Requirements:** REQ-19  
**Design:** Section 7.3 Lazy Loading

Implement lazy loading for images:
- Add loading="lazy" to all product images
- Implement blur-up effect for progressive loading
- Lazy load Alpine.js components

**Files to modify:**
- All view files with images
- `resources/css/luxury.css` (add blur-up styles)

---

### Task 17.4: Add Database Indexes*
**Requirements:** REQ-19  
**Design:** Section 7.4 Database Indexing

Verify and add missing database indexes:
- Composite indexes for common queries
- Foreign key indexes
- Search indexes

**Files to modify:**
- Migration files (if needed)

---

## Phase 18: Security Hardening

### Task 18.1: Implement Input Validation
**Requirements:** REQ-21  
**Design:** Section 8.1 Input Validation

Add comprehensive validation to all forms:
- Product creation/update
- Order creation
- User registration
- Profile updates
- Sanitize all inputs

**Files to modify:**
- All controller methods that handle form submissions

---

### Task 18.2: Implement Rate Limiting
**Requirements:** REQ-21  
**Design:** Section 8.3 Rate Limiting

Implement rate limiting on sensitive endpoints:
- Cart operations: 60 requests per minute
- Order creation: 10 requests per minute
- Authentication: 5 attempts per minute

**Files to modify:**
- `routes/web.php` (add throttle middleware)

---

### Task 18.3: Security Audit*
**Requirements:** REQ-21  
**Design:** Section 8 Security Considerations

Perform security audit:
- Verify CSRF protection on all forms
- Check password hashing
- Verify SQL injection prevention
- Check XSS prevention
- Verify session security
- Test authorization policies

---

## Phase 19: Testing

### Task 19.1: Create Feature Tests for Product Browsing*
**Requirements:** REQ-2, REQ-5, REQ-8  
**Design:** Section 9.1 Feature Tests

Create feature tests:
- test_user_can_view_products_by_global_category
- test_user_can_view_store_page
- test_user_can_view_product_detail
- test_product_shows_store_branding_in_global_view

**Files to create:**
- `tests/Feature/ProductBrowsingTest.php`

---

### Task 19.2: Create Feature Tests for Cart & Checkout*
**Requirements:** REQ-9, REQ-10  
**Design:** Section 9.1 Feature Tests

Create feature tests:
- test_authenticated_user_can_add_to_cart
- test_unauthenticated_user_redirected_to_login
- test_user_can_update_cart_quantity
- test_user_can_remove_from_cart
- test_user_can_complete_checkout

**Files to create:**
- `tests/Feature/CartCheckoutTest.php`

---

### Task 19.3: Create Feature Tests for Merchant Panel*
**Requirements:** REQ-12, REQ-14  
**Design:** Section 9.1 Feature Tests

Create feature tests:
- test_pending_merchant_cannot_access_dashboard
- test_approved_merchant_can_access_dashboard
- test_merchant_can_create_category
- test_merchant_can_create_product
- test_merchant_cannot_exceed_featured_limit

**Files to create:**
- `tests/Feature/MerchantPanelTest.php`

---

### Task 19.4: Create Unit Tests for Models*
**Requirements:** All model requirements  
**Design:** Section 9.2 Unit Tests

Create unit tests:
- test_product_returns_correct_current_price
- test_product_is_in_stock
- test_cart_calculates_total_correctly
- test_order_generates_unique_order_number

**Files to create:**
- `tests/Unit/ProductTest.php`
- `tests/Unit/CartTest.php`
- `tests/Unit/OrderTest.php`

---

### Task 19.5: Run Test Suite*
**Requirements:** All requirements  
**Design:** Section 9 Testing Strategy

Run complete test suite and fix any failures:
```bash
php artisan test
```

---

## Phase 20: Seeding & Demo Data

### Task 20.1: Create GlobalCategory Seeder
**Requirements:** REQ-11  
**Design:** Section 4.2 Database Schema

Create seeder for global categories:
- Fashion & Apparel
- Footwear & Accessories
- Electronics & Gadgets
- Home & Living
- Beauty & Personal Care
- Sports & Outdoors

**Files to create:**
- `database/seeders/GlobalCategorySeeder.php`

---

### Task 20.2: Create Demo Merchant Seeder
**Requirements:** REQ-14  
**Design:** Section 4.2 Database Schema

Create seeder for demo merchants:
- Create 5-10 demo merchants with approved status
- Assign store names, descriptions, logos
- Create merchant categories linked to global categories

**Files to create:**
- `database/seeders/MerchantSeeder.php`

---

### Task 20.3: Create Demo Product Seeder
**Requirements:** REQ-6, REQ-8  
**Design:** Section 4.2 Database Schema

Create seeder for demo products:
- Create 50-100 demo products across merchants
- Assign to merchant categories
- Add product images
- Mark some as featured

**Files to create:**
- `database/seeders/ProductSeeder.php`

---

### Task 20.4: Create Banner Seeder
**Requirements:** REQ-1  
**Design:** Section 4.2 Database Schema

Create seeder for demo banners:
- Create 3-5 cinematic banners
- Add images and links
- Set active dates and order

**Files to create:**
- `database/seeders/BannerSeeder.php`

---

### Task 20.5: Update DatabaseSeeder
**Requirements:** All seeding requirements  
**Design:** Section 4.2 Database Schema

Update main seeder to call all seeders in correct order:
1. GlobalCategorySeeder
2. MerchantSeeder
3. ProductSeeder
4. BannerSeeder

**Files to modify:**
- `database/seeders/DatabaseSeeder.php`

---

### Task 20.6: Run Seeders Checkpoint
**Requirements:** All seeding requirements  
**Design:** Section 4.2

Run all seeders and verify demo data:
```bash
php artisan db:seed
```

Browse the site and verify all pages display correctly with demo data.

---

## Phase 21: Final Polish & Deployment

### Task 21.1: Create Navigation Component
**Requirements:** REQ-1, REQ-18  
**Design:** Section 2.3 Navigation

Create main navigation component with:
- Logo
- Menu items (Home, Categories, Stores, Orders)
- Search bar
- Language switcher
- Cart icon
- User menu (Login/Register or Profile/Logout)
- Responsive mobile menu
- Sticky on scroll

**Files to create:**
- `resources/views/components/navigation.blade.php`

**Files to modify:**
- `resources/views/layouts/app.blade.php`

---

### Task 21.2: Create Footer Component
**Requirements:** REQ-1, REQ-18  
**Design:** Section 2 Component Design System

Create footer component with:
- About section
- Quick links (Categories, Stores, Contact)
- Social media links
- Copyright notice
- Language switcher
- Elegant styling

**Files to create:**
- `resources/views/components/footer.blade.php`

**Files to modify:**
- `resources/views/layouts/app.blade.php`

---

### Task 21.3: Implement Breadcrumb Navigation
**Requirements:** REQ-8  
**Design:** Section 3.4 Product Detail Page

Create breadcrumb component:
- Dynamic breadcrumb generation
- Home > Category > Store > Product
- Clickable links
- Elegant styling

**Files to create:**
- `resources/views/components/breadcrumb.blade.php`

---

### Task 21.4: Add Loading States & Skeletons
**Requirements:** REQ-19  
**Design:** Section 7 Performance Optimization

Add elegant loading states:
- Skeleton screens for product grids
- Loading spinners for AJAX operations
- Progress indicators for multi-step forms
- Smooth transitions

**Files to create:**
- `resources/views/components/skeleton-card.blade.php`
- `resources/views/components/loading-spinner.blade.php`

---

### Task 21.5: Responsive Design Testing
**Requirements:** REQ-18  
**Design:** Section 1 Visual Design System

Test and fix responsive design on all pages:
- Mobile (320px - 767px)
- Tablet (768px - 1023px)
- Desktop (1024px+)
- Test all interactions (hover, click, swipe)
- Verify touch-friendly elements on mobile

---

### Task 21.6: Browser Compatibility Testing
**Requirements:** REQ-18  
**Design:** Non-Functional Requirements

Test on all supported browsers:
- Chrome (latest 2 versions)
- Firefox (latest 2 versions)
- Safari (latest 2 versions)
- Edge (latest 2 versions)
- Mobile browsers (iOS Safari, Chrome Mobile)

---

### Task 21.7: Accessibility Audit*
**Requirements:** REQ-18  
**Design:** Non-Functional Requirements

Perform accessibility audit:
- WCAG 2.1 Level AA compliance
- Keyboard navigation
- Screen reader compatibility
- ARIA labels
- Color contrast ratios
- Focus indicators

---

### Task 21.8: Performance Audit*
**Requirements:** REQ-19  
**Design:** Section 7 Performance Optimization

Perform performance audit:
- Page load times (target < 3 seconds)
- Time to interactive (target < 5 seconds)
- Animation frame rates (target 60fps)
- Lighthouse score (target > 90)
- Optimize bottlenecks

---

### Task 21.9: Create README Documentation
**Requirements:** All requirements  
**Design:** All sections

Create comprehensive README.md with:
- Project overview
- Installation instructions
- Configuration guide
- Seeding instructions
- Admin/Merchant credentials
- Technology stack
- Features list
- Screenshots

**Files to modify:**
- `README.md`

---

### Task 21.10: Environment Configuration
**Requirements:** All requirements  
**Design:** Section 10 Deployment Checklist

Configure production environment:
- Set APP_ENV=production
- Set APP_DEBUG=false
- Configure database credentials
- Set up mail configuration
- Configure queue workers
- Set up cron jobs
- Configure SSL

**Files to modify:**
- `.env.example` (update with all required variables)

---

### Task 21.11: Build Assets for Production
**Requirements:** All requirements  
**Design:** Section 10 Deployment Checklist

Build and optimize assets:
```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

### Task 21.12: Final QA Testing
**Requirements:** All requirements  
**Design:** All sections

Perform comprehensive QA testing:
- Test all user flows (visitor, customer, merchant, admin)
- Test all CRUD operations
- Test authentication and authorization
- Test notifications
- Test error handling
- Test edge cases
- Fix any bugs found

---

## Task Summary

**Total Tasks:** 120+ tasks organized into 21 phases

**Phases Overview:**
1. Foundation & Database (8 tasks)
2. Models & Relationships (9 tasks)
3. Design System & Assets (4 tasks)
4. Localization Setup (3 tasks)
5. Frontend - Landing Page (5 tasks)
6. Frontend - Global Category Pages (3 tasks)
7. Frontend - Store Directory & Pages (6 tasks)
8. Frontend - Product Detail Page (4 tasks)
9. Shopping Cart System (5 tasks)
10. Checkout & Orders (6 tasks)
11. Admin Panel - Filament Resources (6 tasks)
12. Merchant Panel - Filament Resources (5 tasks)
13. Authentication & Authorization (6 tasks)
14. Notifications System (4 tasks)
15. Search & Filtering (4 tasks)
16. User Profile Management (2 tasks)
17. Performance Optimization (4 tasks)
18. Security Hardening (3 tasks)
19. Testing (5 tasks - optional)
20. Seeding & Demo Data (6 tasks)
21. Final Polish & Deployment (12 tasks)

**Recommended Execution Order:**
- Follow phases sequentially for best results
- Complete all tasks in a phase before moving to next
- Run checkpoint tasks to verify progress
- Optional tasks (marked with *) can be done later

**Estimated Timeline:**
- Phase 1-4: 1-2 weeks (Foundation)
- Phase 5-10: 3-4 weeks (Frontend & Core Features)
- Phase 11-16: 2-3 weeks (Admin/Merchant Panels & Additional Features)
- Phase 17-21: 1-2 weeks (Optimization, Testing, Deployment)
- **Total: 7-11 weeks** (depending on team size and experience)

---

## Notes

- Each task references specific requirements and design sections
- Tasks marked with `*` are optional but recommended
- Dependencies are noted where applicable
- Checkpoint tasks help verify progress
- Testing tasks ensure quality
- Final phase ensures production readiness

**Remember the Philosophy:**
> "We are not building a website; we are building an experience. Every pixel, every transition, every animation, every word must serve one purpose: Does this make the merchant feel prestigious and the customer feel amazed?"

---

## Next Steps

1. Review this tasks document with the team
2. Assign tasks to team members
3. Set up project management tool (Jira, Trello, etc.)
4. Create development branch
5. Begin with Phase 1: Foundation & Database
6. Hold daily standups to track progress
7. Review completed phases before moving forward
8. Celebrate milestones! 🎉

