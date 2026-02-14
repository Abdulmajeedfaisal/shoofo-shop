<div align="center">
  <img src="public/images/logo_shoofo_shop_1.png" alt="SHOOFO Shop Logo" width="200"/>

# SHOOFO Shop 🛍️

<div dir="rtl">

### منصة تجارة إلكترونية متعددة التجار - Multi-Merchant E-Commerce Platform

</div>

[![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](https://php.net)
[![Filament](https://img.shields.io/badge/Filament-3.3-F59E0B?style=flat&logo=data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjQiIGhlaWdodD0iMjQiIHZpZXdCb3g9IjAgMCAyNCAyNCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHBhdGggZD0iTTEyIDJMMiAxMkwxMiAyMkwyMiAxMkwxMiAyWiIgZmlsbD0id2hpdGUiLz4KPC9zdmc+&logoColor=white)](https://filamentphp.com)
[![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=flat&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

<div dir="rtl">
<p align="center">
  منصة تجارة إلكترونية حديثة وقوية تدعم متاجر متعددة مع لوحات تحكم منفصلة للمسؤولين والتجار
  <br />
  <a href="#-المميزات"><strong>استكشف المميزات »</strong></a>
  <br />
  <br />
  <a href="#-التثبيت-السريع">التثبيت</a>
  ·
  <a href="#-لقطات-الشاشة">لقطات الشاشة</a>
  ·
  <a href="#-المساهمة">المساهمة</a>
</p>
</div>

</div>

---

<div dir="rtl">

## 📋 جدول المحتويات

- [نظرة عامة](#-نظرة-عامة)
- [المميزات](#-المميزات)
- [التقنيات المستخدمة](#-التقنيات-المستخدمة)
- [المتطلبات](#-المتطلبات)
- [التثبيت السريع](#-التثبيت-السريع)
- [الإعداد والتكوين](#-الإعداد-والتكوين)
- [البيانات التجريبية](#-البيانات-التجريبية)
- [هيكل المشروع](#-هيكل-المشروع)
- [واجهات برمجة التطبيقات](#-واجهات-برمجة-التطبيقات)
- [الأمان](#-الأمان)
- [المساهمة](#-المساهمة)
- [الترخيص](#-الترخيص)

</div>

---

<div dir="rtl">

## 🎯 نظرة عامة

**SHOOFO Shop** هي منصة تجارة إلكترونية متطورة مبنية باستخدام Laravel 12 و Filament 3، مصممة لدعم نموذج الأعمال متعدد التجار (Multi-Vendor Marketplace). توفر المنصة تجربة تسوق سلسة للعملاء مع أدوات إدارة قوية للتجار والمسؤولين.

### ✨ لماذا SHOOFO Shop؟

- 🏪 **نظام متعدد التجار**: يسمح لعدة تجار بإدارة متاجرهم بشكل مستقل
- 🎨 **واجهة مستخدم عصرية**: تصميم متجاوب وجذاب باستخدام Tailwind CSS
- 🌐 **دعم متعدد اللغات**: واجهة كاملة بالعربية والإنجليزية
- 🔐 **نظام صلاحيات متقدم**: ثلاثة أدوار (Admin, Merchant, Customer)
- 📊 **لوحات تحكم احترافية**: باستخدام Filament Admin Panel
- 🛒 **نظام سلة تسوق متطور**: مع دعم الطلبات المقسمة حسب التاجر
- 📦 **إدارة شحن مرنة**: خيارات شحن قابلة للتخصيص لكل تاجر

</div>

---

<div dir="rtl">

## 🚀 المميزات

### للعملاء 👥

- ✅ تصفح المنتجات حسب الفئات العامة والمتاجر
- ✅ بحث متقدم ثلاثي (منتجات، متاجر، فئات) مع اقتراحات فورية
- ✅ فلترة متقدمة (السعر، المخزون، الترتيب، المتجر)
- ✅ سلة تسوق ذكية مع حساب تلقائي للشحن لكل تاجر
- ✅ نظام طلبات مقسم (طلب رئيسي + طلبات فرعية لكل تاجر)
- ✅ تتبع الطلبات مع حالات متعددة
- ✅ نظام إشعارات قاعدة البيانات في الوقت الفعلي
- ✅ واجهة متعددة اللغات كاملة (عربي/إنجليزي) مع RTL
- ✅ عداد مشاهدات المنتجات
- ✅ منتجات مميزة ومقترحة
- ✅ طرق دفع متعددة (COD, Credit Card, Bank Transfer)

### للتجار 🏪

- ✅ لوحة تحكم Filament مخصصة لكل تاجر (`/merchant`)
- ✅ إدارة كاملة للمنتجات (CRUD) مع دعم SKU
- ✅ إدارة الفئات الخاصة بالمتجر مرتبطة بالفئات العامة
- ✅ نظام طلبات فرعية (Merchant Orders) مستقل لكل تاجر
- ✅ إدارة حالات الطلبات (تأكيد، تجهيز، شحن، تسليم، إلغاء)
- ✅ Widgets متقدمة (إحصائيات المتجر، الإيرادات، آخر المنتجات، الطلبات)
- ✅ إدارة إعدادات المتجر (الاسم، الوصف، الشعار، صورة الغلاف)
- ✅ نظام شحن مرن (مجاني، ثابت، محسوب حسب العتبة)
- ✅ رفع صور متعددة للمنتجات مع تحديد الصورة الرئيسية
- ✅ نظام موافقة ثلاثي (pending, approved, rejected)
- ✅ صفحات انتظار وإشعارات للتجار غير المعتمدين
- ✅ دعم المنتجات المميزة مع ترتيب مخصص
- ✅ إدارة الأسعار والتخفيضات (price, sale_price)

### للمسؤولين 👨‍💼

- ✅ لوحة تحكم Filament شاملة (`/admin`)
- ✅ إدارة التجار الكاملة (CRUD + الموافقة/الرفض)
- ✅ إدارة الفئات العامة (Global Categories) مع الأيقونات والصور
- ✅ إدارة البانرات الإعلانية مع جدولة زمنية (start_date, end_date)
- ✅ أنواع روابط البانرات (internal, external, category, store, product)
- ✅ إدارة المستخدمين والأدوار (Admin, Merchant, Customer)
- ✅ إدارة جميع المنتجات عبر المنصة
- ✅ مراقبة جميع الطلبات (الرئيسية والفرعية)
- ✅ إدارة إعدادات الشحن العامة
- ✅ Widgets متقدمة (إحصائيات عامة، آخر الطلبات، التجار المعلقين)
- ✅ نظام إشعارات قاعدة البيانات
- ✅ بحث عام في لوحة التحكم (Cmd/Ctrl + K)

</div>

---

## 🛠 التقنيات المستخدمة

### Backend
- **[Laravel 12](https://laravel.com)** - إطار عمل PHP الحديث
- **[Filament 3.3](https://filamentphp.com)** - لوحات تحكم إدارية قوية
- **PHP 8.2+** - أحدث إصدارات PHP
- **MySQL** - قاعدة بيانات علائقية

### Frontend
- **[Tailwind CSS 3](https://tailwindcss.com)** - إطار عمل CSS مع تخصيصات فاخرة
  - ألوان مخصصة (midnight, royal-gold, rose-gold, silver)
  - خطوط عربية (Cairo, Tajawal, Noto Kufi Arabic)
  - خطوط إنجليزية (Playfair Display, Inter, Cormorant)
  - ظلال أنيقة (elegant, luxury shadows)
  - رسوم متحركة مخصصة (fade-in, slide-up, shimmer, pulse-gold)
  - دعم RTL كامل
- **[Alpine.js 3](https://alpinejs.dev)** - JavaScript خفيف الوزن للتفاعلية
- **[Vite 7](https://vitejs.dev)** - أداة بناء سريعة مع HMR
- **[Blade Templates](https://laravel.com/docs/blade)** - محرك القوالب مع مكونات مخصصة

### الحزم الإضافية
- **[Laravel Breeze 2.3](https://laravel.com/docs/breeze)** - نظام المصادقة الكامل
- **[Blade Flags 1.5](https://github.com/outhebox/blade-flags)** - أيقونات الأعلام للغات
- **[Laravel Pail](https://laravel.com/docs/pail)** - عرض السجلات في الوقت الفعلي
- **[Concurrently](https://www.npmjs.com/package/concurrently)** - تشغيل عدة أوامر معاً

---

<div dir="rtl">

## 📦 المتطلبات

قبل البدء، تأكد من توفر المتطلبات التالية:

</div>

- **PHP** >= 8.2
- **Composer** >= 2.0
- **Node.js** >= 18.x
- **NPM** أو **Yarn**
- **MySQL** >= 8.0 أو **MariaDB** >= 10.3
- **Git**

<div dir="rtl">

### ملحقات PHP المطلوبة:

</div>

```
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD أو Imagick
```

---

<div dir="rtl">

## ⚡ التثبيت السريع

### 1️⃣ استنساخ المشروع

</div>

```bash
git clone https://github.com/your-username/shoofo-shop.git
cd shoofo-shop
```

<div dir="rtl">

### 2️⃣ تثبيت الاعتماديات

</div>

```bash
# تثبيت حزم PHP
composer install

# تثبيت حزم JavaScript
npm install
```

<div dir="rtl">

### 3️⃣ إعداد البيئة

</div>

```bash
# نسخ ملف البيئة
cp .env.example .env

# توليد مفتاح التطبيق
php artisan key:generate
```

<div dir="rtl">

### 4️⃣ إعداد قاعدة البيانات

قم بتحديث ملف `.env` بمعلومات قاعدة البيانات:

</div>

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=shoofo_shop
DB_USERNAME=root
DB_PASSWORD=your_password
```

<div dir="rtl">

ثم قم بتشغيل الترحيلات:

</div>

```bash
# إنشاء قاعدة البيانات
php artisan migrate

# تعبئة البيانات التجريبية (اختياري)
php artisan db:seed
```

<div dir="rtl">

### 5️⃣ بناء الأصول

</div>

```bash
# للتطوير
npm run dev

# للإنتاج
npm run build
```

<div dir="rtl">

### 6️⃣ تشغيل المشروع

</div>

```bash
# باستخدام أمر واحد (يشغل جميع الخدمات)
composer dev

# أو بشكل منفصل:
php artisan serve
npm run dev
```

<div dir="rtl">

الآن يمكنك زيارة التطبيق على: `http://localhost:8000`

</div>

---

<div dir="rtl">

## ⚙️ الإعداد والتكوين

### إعدادات التطبيق

في ملف `.env`، يمكنك تخصيص:

</div>

```env
APP_NAME="SHOOFO Shop"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# اللغة الافتراضية
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

<div dir="rtl">

### إعدادات البريد الإلكتروني

</div>

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS="hello@shoofo.com"
MAIL_FROM_NAME="${APP_NAME}"
```

<div dir="rtl">

### إعدادات التخزين

</div>

```bash
# إنشاء رابط رمزي للتخزين العام
php artisan storage:link
```

---

<div dir="rtl">

## 🎭 البيانات التجريبية

بعد تشغيل `php artisan db:seed`، ستحصل على:

### حسابات المستخدمين

</div>

| الدور | البريد الإلكتروني | كلمة المرور | الوصول | الملاحظات |
|------|-------------------|-------------|--------|-----------|
| **Admin** | admin@shoofo.com | password | `/admin` | صلاحيات كاملة |
| **Merchant (Zara)** | zara@shoofo.com | password | `/merchant` | متجر أزياء مميز |
| **Merchant (Nike)** | nike@shoofo.com | password | `/merchant` | متجر رياضي مميز |
| **Merchant (Apple)** | apple@shoofo.com | password | `/merchant` | متجر إلكترونيات مميز |
| **Merchant (H&M)** | hm@shoofo.com | password | `/merchant` | متجر أزياء عادي |
| **Customer** | customer@example.com | password | `/` | حساب عميل للتسوق |

<div dir="rtl">

### البيانات المضمنة

#### الفئات العامة (4)

- Fashion & Clothing / الأزياء والملابس
- Electronics / الإلكترونيات
- Sports & Fitness / الرياضة واللياقة
- Accessories / الإكسسوارات

#### المتاجر (4)

- **Zara**: متجر أزياء عالمي (مميز)
- **Nike**: علامة رياضية رائدة (مميز)
- **Apple**: منتجات تقنية فاخرة (مميز)
- **H&M**: أزياء بأسعار معقولة

#### الفئات الفرعية (7)

- Women's Fashion, Men's Fashion (Zara)
- Running Shoes, Sports Apparel (Nike)
- iPhones, MacBooks (Apple)
- Casual Wear (H&M)

#### المنتجات (8)

مع صور من Unsplash، أسعار واقعية، وأوصاف بالعربية والإنجليزية:

- Elegant Evening Dress (Zara) - 599 ريال (تخفيض: 449)
- Classic Blazer (Zara) - 399 ريال
- Air Max Running Shoes (Nike) - 899 ريال
- Pro Training T-Shirt (Nike) - 149 ريال (تخفيض: 99)
- iPhone 15 Pro Max (Apple) - 5999 ريال
- MacBook Pro 16" (Apple) - 12999 ريال (تخفيض: 11999)
- Cotton T-Shirt (H&M) - 79 ريال
- Denim Jeans (H&M) - 199 ريال

#### البانرات الإعلانية (3)

- Welcome to SHOOFO - بانر ترحيبي
- Discover Luxury Fashion - بانر الأزياء
- Premium Technology - بانر الإلكترونيات

### ميزات البيانات التجريبية

- ✅ جميع الصور من Unsplash (روابط خارجية)
- ✅ أسماء وأوصاف بالعربية والإنجليزية
- ✅ Slugs صديقة لمحركات البحث
- ✅ منتجات مميزة مع ترتيب
- ✅ أسعار تخفيضية لبعض المنتجات
- ✅ كميات مخزون واقعية
- ✅ SKU فريدة لكل منتج

</div>

---

<div dir="rtl">

## 📁 هيكل المشروع

</div>

```
shoofo-shop/
├── app/
│   ├── Filament/
│   │   ├── Resources/          # موارد لوحة المسؤول
│   │   │   ├── BannerResource.php
│   │   │   ├── GlobalCategoryResource.php
│   │   │   ├── MerchantResource.php
│   │   │   ├── OrderResource.php
│   │   │   ├── ProductResource.php
│   │   │   └── UserResource.php
│   │   ├── Merchant/           # لوحة تحكم التاجر
│   │   │   ├── Resources/
│   │   │   │   ├── MerchantCategoryResource.php
│   │   │   │   ├── MerchantOrderResource.php
│   │   │   │   └── ProductResource.php
│   │   │   ├── Pages/
│   │   │   │   └── StoreSettings.php
│   │   │   └── Widgets/
│   │   │       ├── StoreStatsWidget.php
│   │   │       ├── RevenueChartWidget.php
│   │   │       ├── LatestProductsWidget.php
│   │   │       └── MerchantOrdersWidget.php
│   │   ├── Pages/
│   │   │   └── ShippingSettings.php
│   │   └── Widgets/
│   │       ├── StatsOverviewWidget.php
│   │       ├── LatestOrdersWidget.php
│   │       └── PendingMerchantsWidget.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/           # متحكمات المصادقة (Breeze)
│   │   │   ├── CartController.php
│   │   │   ├── CheckoutController.php
│   │   │   ├── GlobalCategoryController.php
│   │   │   ├── HomeController.php
│   │   │   ├── OrderController.php
│   │   │   ├── ProductController.php
│   │   │   ├── SearchController.php
│   │   │   └── StoreController.php
│   │   └── Middleware/
│   │       ├── EnsureMerchantApproved.php
│   │       └── EnsureUserIsAdmin.php
│   ├── Models/
│   │   ├── User.php
│   │   ├── Merchant.php
│   │   ├── GlobalCategory.php
│   │   ├── MerchantCategory.php
│   │   ├── Product.php
│   │   ├── ProductImage.php
│   │   ├── Cart.php
│   │   ├── CartItem.php
│   │   ├── Order.php
│   │   ├── OrderItem.php
│   │   ├── MerchantOrder.php
│   │   ├── Banner.php
│   │   └── ShippingSetting.php
│   └── Providers/
│       └── Filament/
│           ├── AdminPanelProvider.php
│           └── MerchantPanelProvider.php
├── database/
│   ├── migrations/             # 27 ملف ترحيل
│   └── seeders/
│       └── DatabaseSeeder.php  # بيانات تجريبية كاملة
├── resources/
│   ├── views/
│   │   ├── auth/              # صفحات المصادقة
│   │   ├── cart/              # سلة التسوق
│   │   ├── categories/        # الفئات
│   │   ├── checkout/          # الدفع
│   │   ├── components/        # مكونات Blade قابلة لإعادة الاستخدام
│   │   ├── merchant/          # صفحات التاجر (pending, rejected)
│   │   ├── orders/            # الطلبات
│   │   ├── products/          # المنتجات
│   │   ├── search/            # البحث
│   │   ├── stores/            # المتاجر
│   │   └── home.blade.php     # الصفحة الرئيسية
│   ├── css/
│   │   └── app.css            # Tailwind CSS مع تخصيصات
│   └── js/
│       └── app.js             # Alpine.js
├── lang/
│   ├── ar/                    # ملفات اللغة العربية
│   └── en/                    # ملفات اللغة الإنجليزية
├── routes/
│   ├── web.php                # مسارات الواجهة الأمامية
│   └── auth.php               # مسارات المصادقة (Breeze)
├── public/
│   └── images/                # الصور والشعارات
├── tailwind.config.js         # تكوين Tailwind مع ألوان وخطوط مخصصة
├── vite.config.js             # تكوين Vite
└── composer.json              # اعتماديات PHP
```

---

<div dir="rtl">

## 🔌 واجهات برمجة التطبيقات

### المسارات الرئيسية

#### الواجهة الأمامية

</div>

```
GET  /                          # الصفحة الرئيسية (بانرات، فئات، متاجر مميزة)
GET  /categories                # قائمة الفئات العامة
GET  /categories/{slug}         # منتجات الفئة مع فلترة متقدمة
GET  /stores                    # قائمة المتاجر المعتمدة
GET  /stores/{slug}             # صفحة المتجر مع منتجاته
GET  /stores/{merchant}/products/{product}  # تفاصيل المنتج
GET  /search                    # البحث المتقدم (منتجات، متاجر، فئات)
GET  /search/suggestions        # API للاقتراحات الفورية (JSON)
GET  /locale/{locale}           # تبديل اللغة (en/ar)
```

<div dir="rtl">

#### سلة التسوق والطلبات (تتطلب تسجيل دخول)

</div>

```
GET    /cart                      # عرض السلة
POST   /cart/add/{product}        # إضافة للسلة
PATCH  /cart/update/{cartItem}    # تحديث الكمية
DELETE /cart/remove/{cartItem}    # حذف من السلة
DELETE /cart/clear                # تفريغ السلة
GET    /checkout                  # صفحة الدفع مع حساب الشحن
POST   /checkout                  # إتمام الطلب (إنشاء Order + MerchantOrders)
GET    /checkout/success/{order}  # صفحة نجاح الطلب
GET    /orders                    # طلباتي
GET    /orders/{order}            # تفاصيل الطلب مع الطلبات الفرعية
```

<div dir="rtl">

#### لوحات التحكم

</div>

```
/admin                          # لوحة تحكم المسؤول (Filament)
/merchant                       # لوحة تحكم التاجر (Filament)
/merchant/pending               # صفحة انتظار موافقة التاجر
/merchant/rejected              # صفحة رفض التاجر
```

<div dir="rtl">

#### المصادقة (Laravel Breeze)

</div>

```
GET  /login                     # صفحة تسجيل الدخول
POST /login                     # معالجة تسجيل الدخول
GET  /register                  # صفحة التسجيل
POST /register                  # معالجة التسجيل
POST /logout                    # تسجيل الخروج
GET  /forgot-password           # نسيت كلمة المرور
POST /forgot-password           # إرسال رابط إعادة التعيين
GET  /reset-password/{token}    # إعادة تعيين كلمة المرور
POST /reset-password            # معالجة إعادة التعيين
```

<div dir="rtl">

### معلمات الفلترة والبحث

#### فلترة المنتجات

</div>

```
?q=search_term                  # البحث النصي
?store=merchant_id              # فلترة حسب المتجر
?category=global_category_id    # فلترة حسب الفئة
?min_price=100                  # الحد الأدنى للسعر
?max_price=1000                 # الحد الأقصى للسعر
?sort=featured|price_low|price_high|newest|popular  # الترتيب
?in_stock=1                     # المنتجات المتوفرة فقط
?type=all|products|stores       # نوع البحث
```

---

<div dir="rtl">

## 🔐 الأمان

### الممارسات الأمنية المطبقة

- ✅ **حماية CSRF**: جميع النماذج محمية ضد هجمات CSRF باستخدام `@csrf`
- ✅ **تشفير كلمات المرور**: باستخدام Bcrypt مع 12 جولة
- ✅ **التحقق من الصلاحيات**:
  - Middleware مخصصة: `EnsureUserIsAdmin`, `EnsureMerchantApproved`
  - التحقق من ملكية الموارد (Orders, Cart)
  - نظام أدوار ثلاثي (Admin, Merchant, Customer)
- ✅ **حماية SQL Injection**: استخدام Eloquent ORM و Query Builder
- ✅ **XSS Protection**: تنظيف المدخلات تلقائياً عبر Blade `{{ }}`
- ✅ **Rate Limiting**: حماية من الطلبات المتكررة على المصادقة
- ✅ **Session Security**:
  - تشفير الجلسات
  - HTTPS only في الإنتاج
  - Session timeout بعد 120 دقيقة
- ✅ **File Upload Security**:
  - التحقق من أنواع الملفات
  - تخزين آمن في `storage/app`
  - روابط رمزية للوصول العام
- ✅ **Database Security**:
  - استخدام prepared statements
  - Mass assignment protection عبر `$fillable`
  - Soft deletes للبيانات الحساسة

### التوصيات للإنتاج

</div>

```env
# في بيئة الإنتاج
APP_ENV=production
APP_DEBUG=false

# استخدم HTTPS
APP_URL=https://yourdomain.com

# قم بتغيير جميع كلمات المرور الافتراضية
# قم بتعطيل التسجيل العام للتجار إذا لزم الأمر

# استخدم قاعدة بيانات قوية
DB_PASSWORD=strong_random_password

# قم بتفعيل SSL للبريد الإلكتروني
MAIL_ENCRYPTION=tls
```

<div dir="rtl">

### Middleware المخصصة

**EnsureUserIsAdmin**: يتحقق من أن المستخدم لديه دور `admin` قبل الوصول للوحة التحكم

**EnsureMerchantApproved**: يتحقق من:
- المستخدم لديه دور `merchant`
- لديه ملف تاجر مرتبط
- حالة التاجر `approved` (وليس `pending` أو `rejected`)
- يوجه التجار غير المعتمدين لصفحات خاصة

</div>

---

<div dir="rtl">

## 🧪 الاختبارات

</div>

```bash
# تشغيل جميع الاختبارات
php artisan test

# تشغيل اختبارات محددة
php artisan test --filter=ProductTest

# مع تغطية الكود
php artisan test --coverage
```

---

<div dir="rtl">

## 🚀 النشر

### متطلبات الخادم

</div>

- PHP 8.2+
- MySQL 8.0+
- Composer
- Node.js & NPM

<div dir="rtl">

### خطوات النشر

</div>

1. **رفع الملفات للخادم**
2. **تثبيت الاعتماديات**:
   ```bash
   composer install --optimize-autoloader --no-dev
   npm install && npm run build
   ```
3. **إعداد البيئة**:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. **تشغيل الترحيلات**:
   ```bash
   php artisan migrate --force
   ```
5. **تحسين الأداء**:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
6. **إعداد الصلاحيات**:
   ```bash
   chmod -R 755 storage bootstrap/cache
   ```

---

<div dir="rtl">

## 🤝 المساهمة

نرحب بمساهماتكم! إذا كنت ترغب في المساهمة:

1. Fork المشروع
2. أنشئ فرع للميزة الجديدة (`git checkout -b feature/AmazingFeature`)
3. Commit التغييرات (`git commit -m 'Add some AmazingFeature'`)
4. Push للفرع (`git push origin feature/AmazingFeature`)
5. افتح Pull Request

### إرشادات المساهمة

- اتبع معايير كتابة الكود PSR-12
- اكتب اختبارات للميزات الجديدة
- حدّث التوثيق عند الحاجة
- تأكد من أن جميع الاختبارات تعمل

</div>

---

<div dir="rtl">

## 📝 الترخيص

هذا المشروع مرخص تحت رخصة MIT - انظر ملف [LICENSE](LICENSE) للتفاصيل.

</div>

---

<div dir="rtl">

## 👨‍💻 المطور

تم تطوير هذا المشروع بواسطة فريق SHOOFO

</div>

---

<div dir="rtl">

## 📞 الدعم

إذا واجهت أي مشاكل أو لديك أسئلة:

- 📧 البريد الإلكتروني: support@shoofo.com
- 🐛 الإبلاغ عن مشكلة: [GitHub Issues](https://github.com/your-username/shoofo-shop/issues)
- 📖 التوثيق: [Wiki](https://github.com/your-username/shoofo-shop/wiki)

</div>

---

<div dir="rtl">

## 🙏 شكر وتقدير

- [Laravel](https://laravel.com) - إطار العمل الرائع
- [Filament](https://filamentphp.com) - لوحات التحكم الاحترافية
- [Tailwind CSS](https://tailwindcss.com) - التصميم العصري
- [Unsplash](https://unsplash.com) - الصور المجانية

</div>

---

<div align="center">
  <p>صُنع بـ ❤️ في السعودية</p>
  <p>
    <a href="#top">⬆️ العودة للأعلى</a>
  </p>
</div>

---

<div dir="rtl">

## 🎨 التصميم والواجهة

### نظام الألوان الفاخر

المشروع يستخدم لوحة ألوان مخصصة فاخرة:

- **Midnight** (#0A1628): اللون الأساسي الداكن
- **Royal Gold** (#D4AF37): الذهبي الملكي للعناصر المميزة
- **Rose Gold** (#B76E79): الذهبي الوردي للمسات الأنيقة
- **Silver** (#C0C0C0): الفضي للعناصر الثانوية
- **Cream** (#FAF9F6): الكريمي للخلفيات

### الخطوط

#### للغة الإنجليزية:
- **Playfair Display**: للعناوين الفاخرة
- **Inter**: للنصوص العادية
- **Cormorant Garamond**: للنصوص الأنيقة

#### للغة العربية:
- **Cairo**: الخط الأساسي
- **Tajawal**: خط بديل
- **Noto Kufi Arabic**: للعناوين

### الرسوم المتحركة المخصصة

- `fade-in`, `fade-out`: ظهور واختفاء سلس
- `fade-in-up`, `fade-in-down`: حركة مع ظهور
- `slide-up`, `slide-down`: انزلاق عمودي
- `scale-in`: تكبير تدريجي
- `float`: حركة عائمة
- `pulse-gold`: نبض ذهبي
- `shimmer`: تأثير لامع
- `bounce-elegant`: ارتداد أنيق

### الظلال الأنيقة

- `shadow-elegant`: ظل خفيف
- `shadow-elegant-lg`: ظل متوسط
- `shadow-elegant-xl`: ظل كبير
- `shadow-elegant-2xl`: ظل ضخم
- `shadow-luxury`: ظل فاخر مخصص

### دعم RTL كامل

- تبديل تلقائي للاتجاه حسب اللغة
- فئات مساعدة: `.rtl`, `.ltr`
- تخطيط متجاوب يدعم الاتجاهين

</div>

---

<div dir="rtl">

## 🗄️ قاعدة البيانات

### الجداول الرئيسية (27 جدول)

#### المستخدمون والصلاحيات
- `users`: المستخدمون (role: admin, merchant, customer)
- `merchants`: ملفات التجار (status: pending, approved, rejected)

#### الفئات والمنتجات
- `global_categories`: الفئات العامة للمنصة
- `merchant_categories`: فئات كل تاجر (مرتبطة بالفئات العامة)
- `products`: المنتجات (مع SKU, price, sale_price, quantity)
- `product_images`: صور المنتجات (مع is_primary)

#### سلة التسوق
- `carts`: سلة التسوق لكل مستخدم
- `cart_items`: عناصر السلة

#### الطلبات
- `orders`: الطلبات الرئيسية
- `order_items`: عناصر الطلبات
- `merchant_orders`: الطلبات الفرعية لكل تاجر (sub-orders)

#### المحتوى
- `banners`: البانرات الإعلانية (مع جدولة زمنية)

#### الإعدادات
- `shipping_settings`: إعدادات الشحن (key-value)

#### النظام
- `cache`: التخزين المؤقت
- `jobs`: قائمة انتظار المهام
- `notifications`: الإشعارات
- `sessions`: الجلسات

### العلاقات الرئيسية

</div>

```
User (1) ──→ (1) Merchant
User (1) ──→ (1) Cart
User (1) ──→ (*) Orders

Merchant (1) ──→ (*) MerchantCategories
Merchant (1) ──→ (*) Products
Merchant (1) ──→ (*) MerchantOrders

GlobalCategory (1) ──→ (*) MerchantCategories

MerchantCategory (1) ──→ (*) Products

Product (1) ──→ (*) ProductImages
Product (1) ──→ (*) CartItems
Product (1) ──→ (*) OrderItems

Cart (1) ──→ (*) CartItems

Order (1) ──→ (*) OrderItems
Order (1) ──→ (*) MerchantOrders

MerchantOrder (1) ──→ (*) OrderItems
```

---

<div dir="rtl">

## 🚢 نظام الشحن المتقدم

### أنواع الشحن العامة

1. **مجاني** (`free`): شحن مجاني لجميع الطلبات
2. **ثابت** (`fixed`): تكلفة ثابتة لكل طلب
3. **حسب العتبة** (`threshold`): مجاني فوق مبلغ معين، وإلا ثابت
4. **حسب التاجر** (`per_merchant`): كل تاجر يحدد إعداداته

### إعدادات الشحن للتاجر

عندما يُسمح للتاجر بإدارة الشحن:

- **مجاني** (`free`): شحن مجاني لمنتجات هذا التاجر
- **ثابت** (`fixed`): تكلفة ثابتة يحددها التاجر
- **محسوب** (`calculated`): شحن ثابت مع شحن مجاني فوق عتبة معينة

### حساب الشحن في الطلبات

- يتم تقسيم الطلب حسب التجار
- كل تاجر له `MerchantOrder` منفصل
- يُحسب الشحن لكل تاجر بشكل مستقل
- المجموع النهائي = مجموع الشحن من جميع التجار

</div>

---

<div dir="rtl">

## 📊 نظام الطلبات المتقدم

### هيكل الطلبات

</div>

```
Order (الطلب الرئيسي)
├── order_number: SHF-XXXXXXXX
├── status: pending → confirmed → processing → shipped → delivered
├── subtotal: مجموع المنتجات
├── shipping: مجموع الشحن من جميع التجار
├── total: المجموع النهائي
│
└── MerchantOrders (الطلبات الفرعية)
    ├── MerchantOrder #1 (التاجر الأول)
    │   ├── sub_order_number: SHF-XXXXXXXX-1
    │   ├── status: مستقل عن الطلب الرئيسي
    │   ├── subtotal: مجموع منتجات هذا التاجر
    │   ├── shipping_cost: شحن هذا التاجر
    │   └── OrderItems: عناصر هذا التاجر
    │
    └── MerchantOrder #2 (التاجر الثاني)
        ├── sub_order_number: SHF-XXXXXXXX-2
        └── ...
```

<div dir="rtl">

### حالات الطلبات

1. **pending**: قيد الانتظار (بعد الإنشاء مباشرة)
2. **confirmed**: مؤكد (التاجر أكد الطلب)
3. **processing**: قيد التجهيز (التاجر يجهز المنتجات)
4. **shipped**: تم الشحن (المنتجات في الطريق)
5. **delivered**: تم التسليم (وصلت للعميل)
6. **cancelled**: ملغي (من العميل أو التاجر)

### تحديث حالة الطلب الرئيسي

يتم تحديث حالة الطلب الرئيسي تلقائياً بناءً على حالات الطلبات الفرعية:

- إذا كانت كل الطلبات الفرعية `delivered` → الطلب الرئيسي `delivered`
- إذا كانت كل الطلبات الفرعية `cancelled` → الطلب الرئيسي `cancelled`
- إذا كان أي طلب فرعي `shipped` → الطلب الرئيسي `shipped`
- وهكذا...

</div>

---

<div dir="rtl">

## 🔧 أوامر Composer المخصصة

المشروع يوفر أوامر مخصصة لتسهيل التطوير:

### Setup (الإعداد الأولي)

</div>

```bash
composer setup
```

<div dir="rtl">

يقوم بـ:
1. تثبيت اعتماديات PHP
2. نسخ `.env.example` إلى `.env`
3. توليد مفتاح التطبيق
4. تشغيل الترحيلات
5. تثبيت اعتماديات NPM
6. بناء الأصول

### Dev (التطوير)

</div>

```bash
composer dev
```

<div dir="rtl">

يشغل جميع الخدمات معاً باستخدام `concurrently`:
- `php artisan serve` - خادم Laravel
- `php artisan queue:listen` - معالج قوائم الانتظار
- `php artisan pail` - عرض السجلات
- `npm run dev` - Vite dev server

### Test (الاختبارات)

</div>

```bash
composer test
```

<div dir="rtl">

يقوم بـ:
1. مسح ذاكرة التخزين المؤقت للإعدادات
2. تشغيل جميع الاختبارات

</div>

---

<div dir="rtl">

## 🌍 نظام اللغات المتقدم

### اللغات المدعومة

- **الإنجليزية** (en): اللغة الافتراضية
- **العربية** (ar): مع دعم RTL كامل

### ملفات الترجمة

كل لغة لها ملفات منفصلة:

</div>

```
lang/
├── ar/
│   ├── auth.php          # نصوص المصادقة
│   ├── cart.php          # نصوص السلة
│   ├── checkout.php      # نصوص الدفع
│   ├── general.php       # نصوص عامة
│   ├── home.php          # نصوص الصفحة الرئيسية
│   ├── navigation.php    # نصوص القوائم
│   ├── orders.php        # نصوص الطلبات
│   └── products.php      # نصوص المنتجات
└── en/
    └── ... (نفس الملفات)
```

<div dir="rtl">

### تبديل اللغة

</div>

```php
// في المتصفح
GET /locale/ar  // التبديل للعربية
GET /locale/en  // التبديل للإنجليزية

// في الكود
app()->setLocale('ar');
```

<div dir="rtl">

### حفظ تفضيلات اللغة

- للمستخدمين المسجلين: تُحفظ في قاعدة البيانات (`users.locale`)
- للزوار: تُحفظ في الجلسة (`session.locale`)

### استخدام الترجمة في Blade

</div>

```blade
{{ __('general.welcome') }}
{{ __('cart.add_to_cart') }}
@lang('products.price')
```

<div dir="rtl">

### الحقول متعددة اللغات في قاعدة البيانات

معظم الجداول تحتوي على حقول بالعربية والإنجليزية:

- `name` / `name_ar`
- `description` / `description_ar`
- `title` / `title_ar`
- `store_name` / `store_name_ar`

</div>

---

<div dir="rtl">

## 💡 نصائح وأفضل الممارسات

### للتطوير

1. **استخدم `composer dev`** لتشغيل جميع الخدمات معاً
2. **راقب السجلات** باستخدام `php artisan pail`
3. **استخدم Filament** لإنشاء واجهات إدارية سريعة
4. **اتبع PSR-12** لمعايير كتابة الكود
5. **استخدم Eloquent** بدلاً من SQL الخام

### للأداء

</div>

1. **فعّل التخزين المؤقت** في الإنتاج:
   ```bash
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

2. **استخدم قوائم الانتظار** للمهام الثقيلة:
   ```bash
   php artisan queue:work
   ```

3. **حسّن الصور** قبل رفعها

4. **استخدم CDN** للأصول الثابتة

<div dir="rtl">

### للأمان

1. **لا تكشف معلومات حساسة** في `.env`
2. **استخدم HTTPS** في الإنتاج
3. **حدّث الاعتماديات** بانتظام
4. **راجع السجلات** للأنشطة المشبوهة
5. **فعّل 2FA** لحسابات المسؤولين

</div>

---

<div dir="rtl">

## 🐛 استكشاف الأخطاء

### المشاكل الشائعة

</div>

#### 1. خطأ "Class not found"
```bash
composer dump-autoload
```

#### 2. خطأ في الأصول (CSS/JS)
```bash
npm run build
php artisan view:clear
```

#### 3. خطأ في الصلاحيات
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

#### 4. خطأ في قاعدة البيانات
```bash
php artisan migrate:fresh --seed
```

#### 5. خطأ في التخزين المؤقت
```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

#### 6. Filament لا يعمل
```bash
php artisan filament:upgrade
composer dump-autoload
```

---

<div dir="rtl">

## 📈 خارطة الطريق

### الميزات المستقبلية المخططة

- [ ] نظام تقييمات ومراجعات المنتجات
- [ ] نظام رسائل بين العملاء والتجار
- [ ] تكامل بوابات الدفع (Stripe, PayPal, Tap)
- [ ] نظام كوبونات وخصومات
- [ ] برنامج نقاط الولاء
- [ ] تطبيق موبايل (Flutter)
- [ ] API RESTful كامل
- [ ] نظام تتبع الشحنات
- [ ] تقارير وإحصائيات متقدمة
- [ ] نظام إشعارات البريد الإلكتروني
- [ ] نظام إشعارات SMS
- [ ] دعم عملات متعددة
- [ ] تكامل مع منصات التواصل الاجتماعي

</div>

---
