<div align="center">

# 🌶️ MMV — Mumbaiya Misal Vadapav

### *Dil Bole Wow!!*

**A full-stack restaurant management web application built with Laravel 12**  
100% Vegetarian · Preservative Free · Authentic Maharashtrian Street Food

![Full Stack](https://img.shields.io/badge/Full-Stack-333333?style=flat-square)
![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=flat-square&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.3+-777BB4?style=flat-square&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=flat-square&logo=mysql&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-Templates-FF6B00?style=flat-square&logo=laravel&logoColor=white)
![Admin Panel](https://img.shields.io/badge/Admin-Panel-1a1a2e?style=flat-square)
![RESTful](https://img.shields.io/badge/RESTful-Routes-28a745?style=flat-square)
![License](https://img.shields.io/badge/License-MIT-22c55e?style=flat-square)

</div>

---

## 📌 Table of Contents

- [About the Project](#-about-the-project)
- [Live Demo](#-live-demo)
- [Features](#-features)
- [Tech Stack](#️-tech-stack)
- [Project Structure](#-project-structure)
- [Database Schema](#️-database-schema)
- [Getting Started](#-getting-started)
- [Environment Setup](#️-environment-setup)
- [Admin Panel](#-admin-panel)
- [Default Credentials](#-default-credentials)
- [Screenshots](#-screenshots)
- [API Routes](#️-routes)
- [Contributing](#-contributing)
- [License](#-license)
- [Contact](#-contact)

---

## 🍲 About the Project

**MMV (Mumbaiya Misal Vadapav)** is a complete restaurant web application for an authentic Maharashtrian street food chain. The platform serves both customers and restaurant administrators with a clean, modern interface.

The project covers the **entire business workflow** — from a customer browsing the menu and placing an order online, to an admin managing stock levels, processing orders, handling catering bookings and reviewing franchise enquiries — all in one unified system.

> Built as a real-world production-grade Laravel application following MVC architecture, RESTful routing, and Laravel best practices.

---

## 🚀 Live Demo

> 🔗 Coming Soon — Deployment in progress

---

## ✨ Features

### 🌐 Public / Customer Side
| Feature | Description |
|---|---|
| 🏠 **Home Page** | Hero section, featured dishes, bestsellers, brand story |
| 🍽️ **Menu Page** | Full menu with category filters, search, spice indicators, veg dot |
| 🛒 **Online Ordering** | Live cart with item quantity control, GST calculation, guest + auth checkout |
| 📖 **About Page** | Brand story, core values, milestone timeline |
| 📞 **Contact Page** | Contact form with subject selector and info cards |
| 🎉 **Catering Page** | Event types, benefits section, catering booking form |
| 🏪 **Franchise Page** | Investment models, 5-step process, franchise enquiry form |
| 📸 **Gallery Page** | Collage-style photo grid with lightbox viewer |
| 🔐 **Auth** | Login & Register with role-based redirection |

### 🔧 Admin Panel (`/admin`)
| Module | Capabilities |
|---|---|
| 📊 **Dashboard** | KPI stats, recent orders, low-stock alerts, quick actions |
| 🍽️ **Menu Management** | Full CRUD — add/edit/delete items, image upload, spice level, availability toggle |
| 📦 **Order Management** | View all orders, filter by status, update order status, order detail view |
| 🗃️ **Stock Management** | Inventory tracking, restock with movement history, low-stock alerts |
| 👥 **User Management** | View all customers, order history per user, edit roles |
| 🎉 **Catering Requests** | View and manage catering bookings with pipeline status |
| 🏪 **Franchise Enquiries** | Manage franchise pipeline from new → approved |

---

## 🛠️ Tech Stack

| Layer | Technology |
|---|---|
| **Backend Framework** | Laravel 12.x |
| **Language** | PHP 8.3 |
| **Database** | MySQL 8.0 |
| **ORM** | Eloquent ORM |
| **Templating** | Blade Templates |
| **Authentication** | Laravel Session Auth (custom) |
| **Storage** | Laravel Storage + Symlink |
| **Frontend** | Vanilla CSS, JavaScript (no build step required) |
| **Icons** | Font Awesome 6 |
| **Fonts** | Google Fonts — Playfair Display + Poppins |

---

## 📁 Project Structure

```
mmv-website/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   └── AuthController.php          ← Login, Register, Logout
│   │   │   ├── Admin/
│   │   │   │   ├── DashboardController.php      ← Admin dashboard stats
│   │   │   │   ├── MenuController.php           ← CRUD: Menu items
│   │   │   │   ├── OrderController.php          ← Manage orders
│   │   │   │   ├── StockController.php          ← Stock management
│   │   │   │   ├── UserController.php           ← Manage customers
│   │   │   │   ├── CateringController.php       ← Catering requests
│   │   │   │   └── FranchiseController.php      ← Franchise enquiries
│   │   │   └── Frontend/
│   │   │       ├── HomeController.php           ← All public pages
│   │   │       └── OrderController.php          ← Customer ordering
│   │   └── Middleware/
│   │       └── AdminMiddleware.php              ← Protects /admin routes
│   └── Models/
│       ├── User.php
│       ├── MenuItem.php
│       ├── Order.php
│       ├── OrderItem.php
│       ├── Stock.php
│       ├── StockMovement.php
│       ├── CateringRequest.php
│       └── FranchiseEnquiry.php
├── database/
│   ├── migrations/                             ← 8 migration files
│   └── seeders/
│       └── DatabaseSeeder.php                  ← Demo data + admin user
├── resources/views/
│   ├── layouts/
│   │   ├── app.blade.php                       ← Public site layout
│   │   └── admin.blade.php                     ← Admin panel layout
│   ├── auth/
│   │   ├── login.blade.php
│   │   └── register.blade.php
│   ├── pages/
│   │   ├── home.blade.php
│   │   ├── menu.blade.php
│   │   ├── order.blade.php
│   │   ├── about.blade.php
│   │   ├── contact.blade.php
│   │   ├── catering.blade.php
│   │   ├── franchise.blade.php
│   │   └── gallery.blade.php
│   └── admin/
│       ├── dashboard.blade.php
│       ├── menu/         (index, form)
│       ├── orders/       (index, show)
│       ├── stocks/       (index, form, restock)
│       ├── users/        (index, show, edit)
│       ├── catering/     (index, show)
│       └── franchise/    (index, show)
└── routes/
    └── web.php
```

---

## 🗄️ Database Schema

```
users               → id, name, email, phone, address, role, password
menu_items          → id, name, category, description, price, image, spice_level, is_available, is_bestseller, is_featured
orders              → id, user_id (nullable), guest_*, order_type, status, total_amount, tax_amount, payment_*
order_items         → id, order_id, menu_item_id, quantity, unit_price, subtotal, notes
stocks              → id, name, category, quantity, min_quantity, unit, unit_cost, supplier
stock_movements     → id, stock_id, type (in/out/adjustment), quantity, notes
catering_requests   → id, name, email, phone, event_date, event_type, guests_count, location, status
franchise_enquiries → id, name, email, phone, city, state, investment_capacity, status
```

**Migration run order is handled automatically** — files are numbered `000001` → `000008` to ensure correct FK dependency resolution.

---

## 🏁 Getting Started

### Prerequisites

Make sure you have these installed:

```bash
php --version       # PHP >= 8.2
composer --version  # Composer >= 2.x
mysql --version     # MySQL >= 8.0
git --version       # Git (any recent version)
```

### Installation

**1. Clone the repository**
```bash
git clone https://github.com/YOUR_USERNAME/mmv-website.git
cd mmv-website
```

**2. Install PHP dependencies**
```bash
composer install
```

**3. Copy environment file**
```bash
cp .env.example .env
```

**4. Generate application key**
```bash
php artisan key:generate
```

**5. Create the database**
```sql
CREATE DATABASE mmv_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

**6. Configure `.env`**
```env
APP_NAME="MMV - Mumbaiya Misal Vadapav"
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=mmv_db
DB_USERNAME=root
DB_PASSWORD=your_password
```

**7. Run migrations**
```bash
php artisan migrate
```

**8. Seed demo data**
```bash
php artisan db:seed
```

**9. Create storage symlink**
```bash
php artisan storage:link
```

**10. Start the development server**
```bash
php artisan serve
```

Visit → **http://127.0.0.1:8000** 🎉

---

## ⚙️ Environment Setup

### Register Admin Middleware

**Laravel 12** — add to `bootstrap/app.php`:
```php
->withMiddleware(function (Middleware $middleware) {
    $middleware->alias([
        'admin' => \App\Http\Middleware\AdminMiddleware::class,
    ]);
})
```

**Laravel 10/11** — add to `app/Http/Kernel.php` under `$routeMiddleware`:
```php
'admin' => \App\Http\Middleware\AdminMiddleware::class,
```

### Image Uploads

Menu item images are stored at `storage/app/public/menu/`.  
The `php artisan storage:link` command creates the public symlink automatically.

---

## 🔐 Admin Panel

Access the admin panel at:

```
http://127.0.0.1:8000/admin
```

The admin panel includes:
- **Dashboard** with live stats — total orders, revenue, users, menu items, low stock alerts
- **Menu CRUD** — create/edit/delete items with image upload
- **Order Pipeline** — filter by status (pending → processing → ready → completed)
- **Stock Tracker** — inventory levels with restock history log
- **User Manager** — view customers and their order history
- **Catering Pipeline** — manage event bookings
- **Franchise Pipeline** — manage franchise applications

---

## 🔑 Default Credentials

After seeding, use these to log in:

| Role | Email | Password |
|------|-------|----------|
| **Admin** | `admin@mmv.com` | `admin@123` |

> ⚠️ Change the admin password immediately in production via the user edit panel.

---

## 📸 Screenshots

> Screenshots will be added after deployment.

| Page | Preview |
|------|---------|
| Home | _(coming soon)_ |
| Menu | _(coming soon)_ |
| Admin Dashboard | _(coming soon)_ |
| Order Management | _(coming soon)_ |

---

## 🗺️ Routes

### Public Routes
```
GET  /                  → Home page
GET  /menu              → Browse menu (filter + search)
GET  /order             → Place an order
POST /order             → Submit order
GET  /about             → About MMV
GET  /contact           → Contact page
POST /contact           → Send contact message
GET  /catering          → Catering services
POST /catering          → Submit catering request
GET  /franchise         → Franchise page
POST /franchise         → Submit franchise enquiry
GET  /gallery           → Photo gallery
GET  /login             → Login page
POST /login             → Authenticate
GET  /register          → Register page
POST /register          → Create account
POST /logout            → Log out
```

### Admin Routes (protected: auth + admin middleware)
```
GET    /admin                       → Dashboard
GET    /admin/menu                  → Menu list
POST   /admin/menu                  → Create item
GET    /admin/menu/{id}/edit        → Edit form
PUT    /admin/menu/{id}             → Update item
DELETE /admin/menu/{id}             → Delete item
GET    /admin/orders                → Orders list
GET    /admin/orders/{id}           → Order detail
PATCH  /admin/orders/{id}/status    → Update status
GET    /admin/stocks                → Stock list
POST   /admin/stocks                → Add stock item
GET    /admin/stocks/{id}/restock   → Restock form
POST   /admin/stocks/{id}/restock   → Process restock
GET    /admin/users                 → Users list
GET    /admin/users/{id}            → User profile
GET    /admin/catering              → Catering requests
PATCH  /admin/catering/{id}/status  → Update status
GET    /admin/franchise             → Franchise enquiries
PATCH  /admin/franchise/{id}/status → Update status
```

---

## 🌱 Seeded Data

The `DatabaseSeeder` populates:

- **1 Admin user** — `admin@mmv.com`
- **22 Menu items** across 7 categories:
  - Misal (4), Vadapav (3), Poha (4), Beverages (4), Thali (1), Snacks (4), Desserts (2)
- **20 Stock items** across 5 categories:
  - Raw Materials, Spices, Dairy, Beverages, Packaging

---

## 🤝 Contributing

Contributions are welcome! Here's how:

```bash
# 1. Fork the repository
# 2. Create your feature branch
git checkout -b feature/your-feature-name

# 3. Commit your changes (use conventional commits)
git commit -m "feat: add online payment gateway integration"

# 4. Push to your branch
git push origin feature/your-feature-name

# 5. Open a Pull Request
```

### Commit Message Convention
```
feat:     New feature
fix:      Bug fix
docs:     Documentation changes
style:    Formatting, missing semicolons, etc.
refactor: Code restructuring
test:     Adding tests
chore:    Build process or tooling changes
```

---

## 📄 License

This project is licensed under the **MIT License** — see the [LICENSE](LICENSE) file for details.

---

## 📬 Contact

**MMV — Mumbaiya Misal Vadapav**  
<!-- 🌐 [mmvmumbaiya.com](https://ca.mmvmumbaiya.com)   -->
📧 devbhavsar.ds@gmail.com

---

<div align="center">

Made with ❤️ and 🌶️ for the love of authentic Maharashtrian Street Food

**⭐ Star this repo if you found it useful!**

</div># MMV
