<div align="center">

# MMV - Mumbaiya Misal Vadapav

### Dil Bole Wow!!

Laravel 12 full-stack restaurant web application for menu browsing, ordering, admin operations, stock tracking, catering, and franchise workflows.

</div>

## Table of Contents

- [About](#about)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Preview Routes](#preview-routes)
- [Admin Panel](#admin-panel)
- [Default Credentials](#default-credentials)
- [Deploy](#deploy)
- [Testing](#testing)
- [API](#api)
- [Contributing](#contributing)
- [License](#license)

## About

MMV (Mumbaiya Misal Vadapav) is a restaurant management platform for an authentic Maharashtrian street food brand. Customers can browse the menu, place orders, and submit catering or franchise enquiries, while the admin panel handles menu management, orders, stock alerts, and operational workflows.

## Features

- Public marketing pages for home, menu, about, contact, catering, franchise, gallery, and careers.
- Restaurant ordering flow with cart, checkout, order confirmation, and guest or authenticated ordering support.
- Admin dashboard with low-stock alerts, recent orders, catering requests, franchise enquiries, and menu management.
- JSON API for menu browsing and order placement, with Sanctum-protected order detail access.

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 12 |
| Language | PHP 8.2+ |
| Database | MySQL 8.0+ |
| Frontend | Blade, Alpine.js, Tailwind CSS via Vite |
| Authentication | Session auth + Laravel Sanctum |
| Testing | PHPUnit / `php artisan test` |

## Getting Started

### Prerequisites

- PHP 8.2+
- Composer 2+
- Node.js 20+
- npm 10+
- MySQL 8.0+

### Local setup

```bash
git clone https://github.com/YOUR_USERNAME/mmv-website.git
cd mmv-website
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
npm run build
php artisan serve
```

Visit `http://127.0.0.1:8000`.

## Preview Routes

Run locally and visit the routes listed below to preview each page.

```text
GET  /             Home page
GET  /menu         Menu listing
GET  /about        About page
GET  /contact      Contact page
GET  /catering     Catering page
GET  /franchise    Franchise page
GET  /gallery      Gallery page
GET  /careers      Careers page
GET  /login        Login page
GET  /register     Register page
GET  /admin        Admin dashboard
```

## Admin Panel

The admin panel lives at `http://127.0.0.1:8000/admin` and includes:

- Dashboard stats and low-stock alerts
- Menu CRUD
- Order tracking
- Stock management
- Catering request management
- Franchise enquiry management
- User management

## Default Credentials

After seeding:

| Role | Email | Password |
|---|---|---|
| Admin | `admin@mmv.com` | `admin@123` |

## Deploy

### One-click Railway deployment

1. Push this repository to GitHub.
2. In Railway, choose `New Project` and select `Deploy from GitHub repo`.
3. Add the project repository, then configure MySQL or attach a Railway database service.
4. Set environment variables such as `APP_NAME`, `APP_ENV=production`, `APP_KEY`, `APP_URL`, `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, and `DB_PASSWORD`.
5. Set the build command to `composer install --no-interaction --prefer-dist && npm ci && npm run build`.
6. Set the start command to `php artisan migrate --force && php artisan db:seed --force && php artisan serve --host=0.0.0.0 --port=$PORT`.
7. After the first deploy, open the Railway-generated URL and log in with the seeded admin credentials.

## Testing

Run the full test suite with:

```bash
php artisan test
```

## API

Base path: `/api`

### Endpoints

- `GET /api/menu`
- `GET /api/menu/{id}`
- `POST /api/orders`
- `GET /api/orders/{id}` requires Sanctum authentication and only returns the authenticated user's own order

### Example curl commands

```bash
curl http://127.0.0.1:8000/api/menu
```

```bash
curl http://127.0.0.1:8000/api/menu/1
```

```bash
curl -X POST http://127.0.0.1:8000/api/orders \
  -H "Accept: application/json" \
  -H "Content-Type: application/json" \
  -d '{
    "guest_name": "Guest Customer",
    "guest_email": "guest@example.com",
    "guest_phone": "9999999999",
    "order_type": "pickup",
    "payment_method": "cash",
    "items": [
      { "id": 1, "quantity": 2 }
    ]
  }'
```

```bash
curl http://127.0.0.1:8000/api/orders/1 \
  -H "Accept: application/json" \
  -H "Authorization: Bearer YOUR_SANCTUM_TOKEN"
```

## Contributing

```bash
git checkout -b feature/your-feature-name
git commit -m "feat: describe-your-change"
git push origin feature/your-feature-name
```

## License

This project is licensed under the MIT License. See [LICENSE](LICENSE).

## Suggested GitHub Topics

`laravel`, `php`, `restaurant-management`, `admin-panel`, `rest-api`, `full-stack`
