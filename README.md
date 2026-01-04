# SHOOFO Shop

تطبيق متجر إلكتروني مبني باستخدام Laravel.

## المتطلبات

- PHP ^8.2
- Composer
- Node.js & NPM

## التثبيت

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run build
```

## التشغيل

```bash
composer dev
```

أو بشكل منفصل:

```bash
php artisan serve
npm run dev
```

## الرخصة

MIT License
