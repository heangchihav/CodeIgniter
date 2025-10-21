# E-Commerce Website - CodeIgniter 4

A simple e-commerce application built with CodeIgniter 4 and PostgreSQL.

## Features

### Customer Features
- Product catalog with categories
- Shopping cart
- Checkout process (guest or logged-in)
- Customer authentication (Login/Register)
- Customer dashboard
- Order history and tracking
- Profile management
- Responsive design with TailwindCSS

### Admin Features
- Admin authentication (Login/Register)
- Dashboard with statistics
- Product management (CRUD)
- Category management (CRUD)
- Protected admin routes

## Requirements

- PHP 8.1 or higher
- PostgreSQL 12 or higher
- Composer
- PostgreSQL PHP extensions (pgsql, pdo_pgsql)

## Installation

### 1. Install Dependencies

```bash
composer install
```

### 2. Configure Environment

Copy `env` to `.env` and configure your database:

```env
CI_ENVIRONMENT = development

app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = postgres
database.default.password = your_password
database.default.DBDriver = Postgre
database.default.schema = public
database.default.port = 5432
```

### 3. Create Database

Create a PostgreSQL database:

```sql
CREATE DATABASE your_database_name;
```

### 4. Run Migrations

```bash
php spark migrate
```

### 5. Seed Database (Optional)

```bash
php spark db:seed DatabaseSeeder
```

### 6. Start Development Server

```bash
php spark serve
```

Visit: http://localhost:8080

## User Access

### Customer Account
- **Login:** http://localhost:8080/login
- **Register:** http://localhost:8080/register
- **Dashboard:** http://localhost:8080/account

**Customer Features:**
- View order history
- Track order status
- Manage profile
- Faster checkout when logged in

### Admin Panel
- **URL:** http://localhost:8080/admin/login
- **Username:** admin
- **Password:** admin123

**Admin Features:**
- Dashboard with statistics
- Manage products (Create, Edit, Delete)
- Manage categories (Create, Edit, Delete)
- View all orders
- Register new admin users

## Project Structure

```
app/
├── Controllers/
│   ├── Shop.php       # Product browsing
│   ├── Cart.php       # Shopping cart
│   └── Checkout.php   # Order processing
├── Models/
│   ├── CategoryModel.php
│   ├── ProductModel.php
│   ├── CustomerModel.php
│   ├── OrderModel.php
│   └── OrderItemModel.php
├── Views/
│   ├── layout/        # Header & footer
│   └── shop/          # Shop pages
└── Database/
    ├── Migrations/    # Database schema
    └── Seeds/         # Sample data
```

## Database Schema

- **categories** - Product categories
- **products** - Product information
- **customers** - Customer accounts
- **orders** - Order records
- **order_items** - Order line items

## License

MIT License
