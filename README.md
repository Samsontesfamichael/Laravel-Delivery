<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Delivery Logo">
</p>

<h1 align="center">🍔 Laravel Delivery - Restaurant Admin Panel</h1>

<p align="center">
  A powerful and feature-rich restaurant delivery management system built with Laravel. This admin panel provides comprehensive control over all aspects of your food delivery business.
</p>

---

## 🐳 Docker & Monitoring Setup

### Quick Start with Docker

```bash
# Clone and setup
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
cd Laravel-Delivery

# Copy environment file
cp .env.docker .env

# Start all services
docker-compose up -d
```

### Services Running:

| Service | URL | Description |
|---------|-----|-------------|
| 🖥️ **Laravel App** | http://localhost | Main application |
| 🐬 **MySQL** | localhost:3306 | Database |
| 🔴 **Redis** | localhost:6379 | Cache & Queue |
| 📊 **N8N** | http://localhost:5678 | Automation & Webhooks |
| 💬 **Venom (WhatsApp)** | http://localhost:3000 | WhatsApp notifications |

---

## 🔔 N8N Monitoring & Notifications

### Automated Alerts to WhatsApp & Telegram

The system includes n8n workflow automation that monitors your delivery platform and sends real-time notifications.

### Features:

- ✅ **System Health Monitoring** - Checks database, cache, storage every 5 minutes
- ✅ **Order Alerts** - Notifies when orders exceed threshold
- ✅ **Pending Order Warnings** - Alerts when pending orders pile up
- ✅ **Daily Reports** - Automated daily summary to WhatsApp/Telegram
- ✅ **Critical Alerts** - Immediate notification for system failures

### API Endpoints for Monitoring:

```
GET /api/system/status     - Get system status for n8n
GET /api/system/health     - Health check endpoint
GET /api/orders/pending    - Get pending orders
GET /api/orders/today      - Today's orders
GET /api/orders/stats      - Order statistics

POST /api/notify/telegram  - Send Telegram message
POST /api/notify/whatsapp  - Send WhatsApp message
```

---

## 🎨 Design Concept

### Color Palette:
| Color | Hex | Usage |
|-------|-----|-------|
| Primary Orange | `#FF6B35` | Main buttons |
| Dark Blue | `#2E4057` | Sidebar |
| Teal | `#1ABC9C` | Success states |
| Warning Amber | `#F39C12` | Warnings |

---

## 🚀 Features

### 👥 User Management
- Users
- User Profile Settings
- Social Authentication

### 🍔 Restaurant Management
- Restaurants
- Restaurant Filters
- Active/Inactive Restaurants
- Restaurant Payouts

### 🍕 Food Management
- Food Category List
- Food List

### 📦 Order Management
- Orders
- Order Reviews
- Order Transactions

### 💳 Financial Management
- Coupons
- Create Coupon
- Payments List
- Currencies
- Wallet

### 🚗 Delivery Management
- Driver List
- Available Drivers
- On Trip Drivers
- Driver Tips

### ⚙️ System Settings
- Google Map Setting
- Social Authentication Setting
- Push Notification Setting
- Payment Method Setting
- User Profile Setting
- Language Settings

---

## 🛠️ Technology Stack

| Technology | Purpose |
|------------|---------|
| Laravel 10.x | Backend |
| Bootstrap 5 | CSS |
| MySQL | Database |
| Redis | Cache/Queue |
| N8N | Automation |
| Venom | WhatsApp |
| Telegram Bot | Notifications |

---

## 📋 Installation

```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install

# Setup environment
cp .env.docker .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Start server
php artisan serve

# Or use Docker
docker-compose up -d
```

---

## 📝 License

MIT License

---

## 📧 Contact

- **Email:** teshag2006@gmail.com
- **GitHub:** [Samsontesfamichael](https://github.com/Samsontesfamichael)

---

<p align="center">Built with ❤️ using Laravel</p>
