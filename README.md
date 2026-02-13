<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Delivery Logo">
</p>

<h1 align="center">🍔 Laravel Delivery - Restaurant Admin Panel</h1>

<p align="center">
  A powerful and feature-rich restaurant delivery management system built with Laravel. This admin panel provides comprehensive control over all aspects of your food delivery business.
</p>

---

## 🎨 Design Concept

Our Admin Panel features a **modern, clean, and intuitive interface** with:

- 🎯 **Clean Dashboard** - At-a-glance metrics with colorful charts
- 📱 **Responsive Design** - Works on desktop, tablet, and mobile
- 🎨 **Color Scheme**:
  - Primary: `#FF6B35` (Vibrant Orange)
  - Secondary: `#2E4057` (Dark Blue)
  - Accent: `#1ABC9C` (Teal)
  - Success: `#27AE60` (Green)
  - Warning: `#F39C12` (Amber)
  - Background: `#F8F9FA` (Light Gray)

---

## 🚀 Features Overview

### 👥 User Management
| Feature | Icon | Description |
|---------|------|-------------|
| **Users** | 👥 | Manage registered customers, view profiles, track activity |
| **User Profile Settings** | ⚙️ | Allow users to update personal information, preferences |
| **Social Authentication** | 🔐 | Login via Google, Facebook, and other social platforms |

### 🍔 Restaurant Management
| Feature | Icon | Description |
|---------|------|-------------|
| **Restaurants** | 🏪 | Full CRUD operations for restaurant partners |
| **Restaurant Filters** | 🔍 | Search and filter restaurants by cuisine, location, rating |
| **Active/Inactive Restaurants** | ✅❌ | Manage restaurant approval status |
| **New Restaurant** | ➕ | New restaurant onboarding process |
| **Restaurant Payouts** | 💰 | Manage payment settlements for restaurants |

### 🍕 Food Management
| Feature | Icon | Description |
|---------|------|-------------|
| **Food Category List** | 📂 | Organize food items into categories |
| **Food List** | 🍔 | Manage menu items with detailed information, pricing |

### 📦 Order Management
| Feature | Icon | Description |
|---------|------|-------------|
| **Orders** | 📋 | Track and manage all delivery orders |
| **Order Reviews** | ⭐ | Review and process customer orders |
| **Order Transactions** | 💳 | View detailed transaction history |

### 💳 Financial Management
| Feature | Icon | Description |
|---------|------|-------------|
| **Coupons** | 🎟️ | View and manage discount coupons |
| **Create Coupon** | ✨ | Generate new promotional codes |
| **Payments List** | 💵 | View all transaction records |
| **Currencies** | 💱 | Multi-currency support |
| **Wallet** | 👜 | User wallet and balance tracking |

### 🚗 Delivery Management
| Feature | Icon | Description |
|---------|------|-------------|
| **Driver List** | 🚚 | Manage delivery personnel |
| **Available Drivers** | ✅ | Track driver availability status |
| **On Trip Drivers** | 🏃 | Track active deliveries |
| **Driver Tips** | 👍 | Manage driver tips and earnings |

### ⚙️ System Settings
| Feature | Icon | Description |
|---------|------|-------------|
| **Google Map Setting** | 🗺️ | Configure Google Maps API integration |
| **Push Notification Setting** | 🔔 | Manage push notifications |
| **Payment Method Setting** | 💳 | Configure payment gateways |
| **User Profile Setting** | 👤 | Admin profile configuration |
| **Language Settings** | 🌐 | Multi-language support |

---

## 🖥️ Dashboard Mockup Design

```
┌─────────────────────────────────────────────────────────────────┐
│  🍔 Laravel Delivery Admin          [Profile] [Settings] [Logout]│
├─────────────────────────────────────────────────────────────────┤
│ ┌──────────┐ ┌──────────┐ ┌──────────┐ ┌──────────┐           │
│ │ 📊 Total │ │ 🍔 Orders│ │ 💰 Earnings│ │ 🚚 Drivers│           │
│ │   1,234  │ │    567   │ │ $45,678   │ │    89    │           │
│ └──────────┘ └──────────┘ └──────────┘ └──────────┘           │
├─────────────────────────────────────────────────────────────────┤
│                                                                  │
│   📈 Orders This Week                                           │
│   ┌─────────────────────────────────────────────────────────┐  │
│   │                                                         │  │
│   │    █                                                   │  │
│   │  █ █        █                                         │  │
│   │ █ █ █    █ █        █                               │  │
│   │ █ █ █  █ █ █    █ █ █    █                         │  │
│   │ ───────────────────────────────────────────────────  │  │
│   │ Mon Tue Wed Thu Fri Sat Sun                           │  │
│   └─────────────────────────────────────────────────────────┘  │
│                                                                  │
├─────────────────────────────────────────────────────────────────┤
│  🏪 Recent Restaurants    🔍 Search...     [+ Add Restaurant]   │
│  ┌──────────────────────────────────────────────────────────┐  │
│  │ 🖼️ Burger King      ⭐4.5  👤 John   ✅ Active           │  │
│  │ 🖼️ Pizza Hut        ⭐4.2  👤 Sarah  ✅ Active           │  │
│  │ 🖼️ KFC             ⭐4.8  👤 Mike   ❌ Inactive         │  │
│  │ 🖼️ Subway          ⭐4.0  👤 Emma   ✅ Active           │  │
│  └──────────────────────────────────────────────────────────┘  │
│                                                                  │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🎨 UI Color Palette & Style Guide

### Primary Colors
| Color | Hex | Usage |
|-------|-----|-------|
| Primary Orange | `#FF6B35` | Main buttons, highlights |
| Dark Blue | `#2E4057` | Sidebar, headers |
| Teal | `#1ABC9C` | Success states, positive metrics |

### Dashboard Cards Design
```
┌─────────────────────────────┐
│  📊 TOTAL ORDERS            │
│  ═══════════════════════   │
│                             │
│      1,234                  │
│      ↑ 12% from last week   │
│                             │
│  ████████████░░░░░░░░░░░░   │
│  Progress: 78%              │
└─────────────────────────────┘
```

### Data Table Design
```
┌──────────────────────────────────────────────────────────────┐
│  🏪 Restaurant Management                      [+ Add New]   │
├──────────────────────────────────────────────────────────────┤
│  🔍 Search restaurants...                    [Filter ▼]     │
├──────┬────────────┬──────────┬─────────┬────────┬──────────┤
│ 🖼️   │ Name       │ Owner    │ Status  │ Rating │ Actions  │
├──────┼────────────┼──────────┼─────────┼────────┼──────────┤
│ [IMG] │ Burger King│ John D.  │ Active  │ ⭐4.5  │ ✏️ 👁️ 🗑️ │
│ [IMG] │ Pizza Hut  │ Sarah M. │ Active  │ ⭐4.2  │ ✏️ 👁️ 🗑️ │
│ [IMG] │ KFC        │ Mike T.  │ Inactive│ ⭐4.8  │ ✏️ 👁️ 🗑️ │
└──────┴────────────┴──────────┴─────────┴────────┴──────────┘
```

---

## 🛠️ Technology Stack

| Technology | Purpose |
|------------|---------|
| Laravel 10.x | Backend Framework |
| Bootstrap 5 | CSS Framework |
| jQuery | JavaScript Library |
| MySQL | Database |
| Laravel Sanctum | API Authentication |
| Google Maps API | Location Services |
| Stripe/PayPal | Payment Gateways |
| Pusher | Real-time Notifications |

---

## 📂 Project Structure

```
├── app/
│   ├── Console/Commands/       # Custom artisan commands
│   ├── Models/                 # Eloquent models
│   ├── Providers/              # Service providers
│   └── Services/               # Business logic
├── Modules/
│   └── AI/                     # AI features
├── config/                     # Configuration
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── public/
│   ├── assets/                # CSS, JS, Images
│   └── images/                # UI images
├── resources/
│   └── views/                 # Blade templates
│       ├── admin_users/       # User management
│       ├── restaurants/       # Restaurant management
│       ├── orders/            # Order management
│       ├── foods/             # Food management
│       ├── coupons/           # Coupon management
│       ├── drivers/           # Driver management
│       └── settings/          # System settings
└── routes/                   # Application routes
```

---

## ⚡ Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL Database
- Git

### Installation

```bash
# Clone the repository
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git

# Install dependencies
composer install
npm install

# Configure environment
cp .env.example .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Start server
php artisan serve
```

---

## 📋 Complete Admin Modules

### 📊 Dashboard
- Overview & Analytics
- Reports & Statistics

### 👥 User Management
- Users List
- User Profile Settings
- Social Authentication

### 🍔 Restaurant Management  
- Restaurant List
- Restaurant Filters
- Active/Inactive Restaurants
- Restaurant Payouts

### 🍕 Food Management
- Food Categories
- Food List

### 📦 Order Management
- Orders List
- Order Reviews
- Order Transactions

### 💳 Financial Management
- Coupons
- Create Coupon
- Payments List
- Currencies

### 🚗 Delivery Management
- Driver List
- Driver Documents
- Driver Payouts

### ⚙️ Settings
- Google Map Setting
- Social Authentication Setting
- Push Notification Setting
- Payment Method Setting
- User Profile Setting

---

## 📝 License

This project is licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 📧 Contact

- **Email:** teshag2006@gmail.com
- **GitHub:** [Samsontesfamichael](https://github.com/Samsontesfamichael)

---

<p align="center">
  <strong>Built with ❤️ using Laravel | Designed with 🎨</strong>
</p>
