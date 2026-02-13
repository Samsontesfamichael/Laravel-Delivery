<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Delivery Logo">
</p>

<h1 align="center">Laravel Delivery - Restaurant Admin Panel</h1>

<p align="center">
  A powerful and feature-rich restaurant delivery management system built with Laravel. This admin panel provides comprehensive control over all aspects of your food delivery business.
</p>

---

## 🚀 Features

### 👥 User Management
| Feature | Description |
|---------|-------------|
| <img src="public/images/users.png" width="30"> **Users** | Manage registered customers, view profiles, track activity |
| <img src="public/images/user-2.png" width="30"> **User Profile Settings** | Allow users to update personal information, preferences |
| <img src="public/images/social.png" width="30"> **Social Authentication** | Login via Google, Facebook, and other social platforms |

### 🍔 Restaurant Management
| Feature | Description |
|---------|-------------|
| <img src="public/images/restaurant.png" width="30"> **Restaurants** | Full CRUD operations for restaurant partners |
| <img src="public/images/restaurant_filters.png" width="30"> **Restaurant Filters** | Search and filter restaurants by cuisine, location, rating |
| <img src="public/images/active_restaurant.png" width="30"> **Active/Inactive Restaurants** | Manage restaurant approval status |
| <img src="public/images/new_restaurant.png" width="30"> **Restaurant Registration** | New restaurant onboarding process |
| <img src="public/images/restaurants_payouts.png" width="30"> **Restaurant Payouts** | Manage payment settlements for restaurants |

### 🍔 Food Management
| Feature | Description |
|---------|-------------|
| <img src="public/images/category.png" width="30"> **Food Category List** | Organize food items into categories |
| <img src="public/images/food.png" width="30"> **Food List** | Manage menu items with detailed information, pricing |

### 📦 Order Management
| Feature | Description |
|---------|-------------|
| <img src="public/images/order.png" width="30"> **Orders** | Track and manage all delivery orders |
| <img src="public/images/cancel_order.png" width="30"> **Order Reviews** | Review and process customer orders |
| <img src="public/images/order_transactions.png" width="30"> **Order Transactions** | View detailed transaction history |

### 💳 Financial Management
| Feature | Description |
|---------|-------------|
| <img src="public/images/coupon.png" width="30"> **Coupons** | View and manage discount coupons |
| <img src="public/images/cashback.png" width="30"> **Create Coupon** | Generate new promotional codes |
| <img src="public/images/payment.png" width="30"> **Payments List** | View all transaction records |
| <img src="public/images/currency.png" width="30"> **Currencies** | Multi-currency support |
| <img src="public/images/wallet.png" width="30"> **Wallet Management** | User wallet and balance tracking |

### 🚗 Delivery Management
| Feature | Description |
|---------|-------------|
| <img src="public/images/driver.png" width="30"> **Driver List** | Manage delivery personnel |
| <img src="public/images/car_available.png" width="30"> **Available Drivers** | Track driver availability status |
| <img src="public/images/car_on_trip.png" width="30"> **On Trip Drivers** | Track active deliveries |
| <img src="public/images/dm-tips.png" width="30"> **Driver Tips** | Manage driver tips and earnings |

### ⚙️ System Settings
| Feature | Description |
|---------|-------------|
| <img src="public/images/location.png" width="30"> **Google Map Setting** | Configure Google Maps API integration |
| <img src="public/images/notification.png" width="30"> **Push Notification Setting** | Manage push notifications |
| <img src="public/images/payment.png" width="30"> **Payment Method Setting** | Configure payment gateways (Stripe, PayPal, etc.) |
| <img src="public/images/settings.png" width="30"> **User Profile Setting** | Admin profile configuration |
| <img src="public/images/language.png" width="30"> **Language Settings** | Multi-language support |

### 📊 Dashboard & Reports
| Feature | Description |
|---------|-------------|
| <img src="public/images/total_order.png" width="30"> **Total Orders** | Order statistics and analytics |
| <img src="public/images/total_earning.png" width="30"> **Total Earnings** | Revenue tracking and reports |
| <img src="public/images/total_payment.png" width="30"> **Total Payments** | Payment analytics |
| <img src="public/images/reports.png" width="30"> **Reports** | Comprehensive business reports |

---

## 🛠️ Technology Stack

- **Backend:** Laravel 10.x
- **Frontend:** Bootstrap 5, jQuery, SCSS, JavaScript
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Maps:** Google Maps API
- **Notifications:** Pusher/OneSignal
- **Payments:** Stripe, PayPal, PayStack, RazorPay, Flutterwave

---

## 📸 Application Screenshots

### Admin Dashboard
![Dashboard](public/images/app_homepage_theme_1.png)

### Restaurant Management
![Restaurants](public/images/restaurant.png)

### Order Management
![Orders](public/images/order.png)

### Payment Methods
![Payments](public/images/payment.png)

---

## 📂 Project Structure

```
├── app/
│   ├── Console/Commands/       # Custom artisan commands
│   ├── Models/                # Eloquent models (User, Order, Restaurant, etc.)
│   ├── Providers/             # Service providers
│   └── Services/              # Business logic services
├── Modules/
│   └── AI/                    # AI-powered features
├── config/                    # Configuration files
├── database/
│   ├── migrations/           # Database migrations
│   └── seeders/              # Database seeders
├── public/
│   ├── assets/               # CSS, JS, Images
│   └── images/               # UI images and icons
├── resources/
│   └── views/                # Blade templates
│       ├── admin_users/      # User management views
│       ├── restaurants/      # Restaurant management
│       ├── orders/           # Order management
│       ├── foods/            # Food management
│       ├── coupons/          # Coupon management
│       ├── drivers/          # Driver management
│       ├── payments/         # Payment settings
│       └── settings/         # System settings
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

1. **Clone the repository**
   ```bash
   git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Configure environment**
   ```bash
   cp .env.example .env
   ```
   
   Update `.env` with your database credentials and API keys.

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database (optional)**
   ```bash
   php artisan db:seed
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

---

## 🔑 Configuration Required

After installation, configure these settings in the admin panel:

1. **Google Maps** - Enter your Google Maps API key in Settings > Google Map
2. **Payment Methods** - Configure Stripe, PayPal, PayStack, or other gateways
3. **Push Notifications** - Set up FCM/OneSignal credentials
4. **Currencies** - Add supported currencies in Settings > Currencies
5. **Social Auth** - Configure OAuth credentials for social login

---

## 📋 All Admin Modules

```
📊 Dashboard
├── Overview & Analytics
├── Reports & Statistics

👥 User Management
├── Users List
├── User Profile Settings
└── Social Authentication

🍔 Restaurant Management  
├── Restaurant List
├── Restaurant Filters
├── Active/Inactive Restaurants
└── Restaurant Payouts

🍕 Food Management
├── Food Categories
├── Food List

📦 Order Management
├── Orders List
├── Order Reviews
└── Order Transactions

💳 Financial Management
├── Coupons
├── Create Coupon
├── Payments List
├── Currencies
└── Wallet Management

🚗 Delivery Management
├── Driver List
├── Driver Documents
└── Driver Payouts

⚙️ Settings
├── Google Map Setting
├── Social Authentication Setting
├── Push Notification Setting
├── Payment Method Setting
├── User Profile Setting
└── Language Settings
```

---

## 📝 License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

---

## 🤝 Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

---

## 📧 Contact

For inquiries or support, please contact:
- **Email:** teshag2006@gmail.com
- **GitHub:** [Samsontesfamichael](https://github.com/Samsontesfamichael)

---

<p align="center">
  <strong>Built with ❤️ using Laravel</strong>
</p>
