<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Delivery Logo">
</p>

<h1 align="center">🍔 Laravel Delivery - Restaurant Admin Panel</h1>

<p align="center">
  A powerful and feature-rich restaurant delivery management system built with Laravel.
</p>

---

## 🎨 New Attractive Color Palette

We've upgraded the design with a fresh, modern, and eye-catching color scheme:

### Primary Colors
| Color Name | Hex Code | Usage |
|------------|----------|-------|
| 🎯 **Electric Purple** | `#8B5CF6` | Primary buttons, highlights |
| 🌊 **Ocean Blue** | `#0EA5E9` | Links, accents |
| 💚 **Fresh Mint** | `#10B981` | Success states |
| 🔥 **Hot Coral** | `#F43F5E` | Important actions |

### Secondary Colors
| Color Name | Hex Code | Usage |
|------------|----------|-------|
| 🌙 **Midnight** | `#1E293B` | Sidebar, dark backgrounds |
| ⭐ **Golden Sun** | `#F59E0B` | Ratings, stars |
| 💜 **Soft Violet** | `#A78BFA` | Secondary buttons |
| 🌫️ **Slate Gray** | `#64748B` | Text, borders |

### Background Colors
| Color Name | Hex Code | Usage |
|------------|----------|-------|
| ❄️ **Snow White** | `#F8FAFC` | Main background |
| 🧊 **Ice Blue** | `#F1F5F9` | Card backgrounds |
| 🌑 **Charcoal** | `#0F172A` | Dark mode |

### Status Colors
| Color Name | Hex Code | Usage |
|------------|----------|-------|
| ✅ **Success Green** | `#22C55E` | Success messages |
| ⚠️ **Warning Amber** | `#F59E0B` | Warnings |
| ❌ **Error Red** | `#EF4444` | Errors |
| ℹ️ **Info Blue** | `#3B82F6` | Information |

---

## 🌈 Gradient Combinations

```
Primary Gradient:    linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%)
Background Gradient: linear-gradient(180deg, #F8FAFC 0%, #E2E8F0 100%)
Card Gradient:      linear-gradient(145deg, #FFFFFF 0%, #F8FAFC 100%)
Dark Gradient:      linear-gradient(180deg, #1E293B 0%, #0F172A 100%)
```

---

## 🖥️ Dashboard Mockup (New Design)

```
┌─────────────────────────────────────────────────────────────────┐
│  🍔 Laravel Delivery Admin        [🔔] [👤 Profile] [⚙️]       │
├─────────────────────────────────────────────────────────────────┤
│ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐           │
│ │ 📊       │ │ 🍔       │ │ 💰       │ │ 🚚       │           │
│ │ Total    │ │ Orders   │ │ Earnings │ │ Drivers  │           │
│ │   1,234  │ │    567   │ │ $45,678  │ │    89    │           │
│ │ 🔼 12%   │ │ 🔼 8%    │ │ 🔼 15%   │ │ 🔽 3%    │           │
│ │#22C55E   │ │#22C55E   │ │#22C55E   │ │#EF4444   │           │
│ └──────────┘ └──────────┘ └──────────┘ └──────────┘           │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│   📈 Orders This Week         [📅 This Week ▼]                   │
│   ┌─────────────────────────────────────────────────────────┐   │
│   │                                                         │   │
│   │    █▓▓                                                │   │
│   │  ▓▓▓▓▓▓    █▓▓                                     │   │
│   │ ▓▓▓▓▓▓▓▓▓▓▓▓▓    █▓▓    █▓▓                       │   │
│   │ ▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓▓    █▓▓    █▓▓    █▓▓      │   │
│   │ ─────────────────────────────────────────────────────   │   │
│   │ Mon  Tue  Wed  Thu  Fri  Sat  Sun                       │   │
│   └─────────────────────────────────────────────────────────┘   │
│                                                                  │
├─────────────────────────────────────────────────────────────────┤
│  🏪 Recent Restaurants    🔍 Search...       [+ Add New]       │
│  ┌──────────────────────────────────────────────────────────┐   │
│  │ 🖼️ Burger King    ⭐4.5  👤 John    🟢 Active           │   │
│  │ 🖼️ Pizza Hut     ⭐4.2  👤 Sarah   🟢 Active           │   │
│  │ 🖼️ KFC           ⭐4.8  👤 Mike    🔴 Inactive        │   │
│  │ 🖼️ Subway        ⭐4.0  👤 Emma    🟢 Active           │   │
│  └──────────────────────────────────────────────────────────┘   │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🐳 Docker & Monitoring Setup

### Quick Start with Docker

```bash
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
cd Laravel-Delivery
cp .env.docker .env
docker-compose up -d
```

### Services Running:
- 🖥️ Laravel App: http://localhost
- 🐬 MySQL: localhost:3306
- 🔴 Redis: localhost:6379
- 📊 N8N: http://localhost:5678
- 💬 WhatsApp: http://localhost:3000

---

## 🚀 Features

### 👥 User Management
- Users, User Profile Settings, Social Authentication

### 🍔 Restaurant Management
- Restaurants, Restaurant Filters, Active/Inactive, Payouts

### 🍕 Food Management
- Food Categories, Food List

### 📦 Order Management
- Orders, Order Reviews, Order Transactions

### 💳 Financial Management
- Coupons, Create Coupon, Payments, Currencies, Wallet

### 🚗 Delivery Management
- Driver List, Available Drivers, On Trip, Driver Tips

### ⚙️ System Settings
- Google Maps, Social Auth, Push Notifications, Payment Methods

---

## 📋 Installation

```bash
composer install
npm install
cp .env.docker .env
php artisan key:generate
php artisan migrate
php artisan serve

# Or Docker
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
