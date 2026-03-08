# Agricart ERP

A professional Laravel 12 ERP landing page with glassmorphism design, multi-language support, and authentication.

## Features

- **Glassmorphism UI** – Modern design with backdrop blur, translucent cards
- **Multi-language** – 15 languages (English, Urdu, Arabic, Spanish, French, German, Chinese, Japanese, Hindi, Portuguese, Russian, Turkish, Bengali, Indonesian, Persian)
- **Authentication** – Login, logout, forgot password (stub), dashboard
- **Responsive** – Mobile, tablet, and desktop optimized
- **Rate limiting** – Login (5/min), forgot password (3/min)

## Requirements

- PHP 8.2+
- Composer
- Node.js & npm
- Laravel 12

## Installation

```bash
# Clone the repository
git clone <repository-url>
cd agricart-erp

# Install PHP dependencies
composer install

# Copy environment file
cp .env.example .env
php artisan key:generate

# Install Node dependencies
npm install
npm run build

# Run migrations
php artisan migrate

# (Optional) Seed test user: test@example.com / password
php artisan db:seed
```

## Development

```bash
# Start Laravel server
php artisan serve

# In another terminal - Vite dev server
npm run dev
```

Visit: http://localhost:8000

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Auth/AuthController.php
│   │   ├── DashboardController.php
│   │   ├── LocaleController.php
│   │   └── PageController.php
│   └── Middleware/SetLocale.php
config/
├── locales.php          # Supported languages
lang/
├── {locale}/app.php     # Translations
resources/
├── views/
│   ├── auth/            # Login, register, forgot-password
│   ├── layouts/app.blade.php
│   ├── pages/           # Privacy, Terms
│   └── welcome.blade.php
```

## Configuration

- **Languages**: Edit `config/locales.php` to add/remove supported locales
- **Brand color**: `#83b735` (used in Tailwind/CSS)

## License

MIT
