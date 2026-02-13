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
- **Users** - Manage registered customers
- **User Profile Settings** - Allow users to update their personal information
- **Social Authentication** - Login via social media platforms (Google, Facebook, etc.)

### 🍔 Restaurant Management
- **Restaurants** - Full CRUD operations for restaurant partners
- **Restaurant Filters** - Search and filter restaurants by various criteria
- **Restaurant Payouts** - Manage payment settlements for restaurants

### 🍕 Food Management
- **Food Category List** - Organize food items into categories
- **Food List** - Manage menu items with detailed information

### 📦 Order Management
- **Orders** - Track and manage all delivery orders
- **Orders Review** - Review and process customer orders

### 💳 Financial Management
- **Coupons** - Create and manage discount coupons
- **Create Coupon** - Generate new promotional codes
- **Payments List** - View all transaction records
- **Currencies** - Multi-currency support

### 🚗 Delivery Management
- **Driver List** - Manage delivery personnel
- **Driver Tracking** - Real-time driver location

### ⚙️ System Settings
- **Google Map Setting** - Configure Google Maps API integration
- **Push Notification Setting** - Manage push notifications
- **Payment Method Setting** - Configure payment gateways
- **User Profile Setting** - Admin profile configuration

---

## 🛠️ Technology Stack

- **Backend:** Laravel 10.x
- **Frontend:** Bootstrap 5, jQuery, SCSS
- **Database:** MySQL
- **Authentication:** Laravel Sanctum
- **Maps:** Google Maps API
- **Notifications:** Pusher/OneSignal

---

## 📸 Screenshots

| Dashboard | Orders | Restaurants |
|-----------|--------|-------------|
| ![Dashboard](public/assets/images/screenshots/dashboard.png) | ![Orders](public/assets/images/screenshots/orders.png) | ![Restaurants](public/assets/images/screenshots/restaurants.png) |

---

## 📂 Project Structure

```
├── app/
│   ├── Console/Commands/       # Custom artisan commands
│   ├── Models/                 # Eloquent models
│   ├── Providers/              # Service providers
│   └── Services/               # Business logic services
├── Modules/                    # Modular Laravel application
├── config/                     # Configuration files
├── database/
│   ├── migrations/            # Database migrations
│   └── seeders/               # Database seeders
├── public/
│   ├── assets/                # CSS, JS, Images
│   └── plugins/              # Third-party plugins
├── resources/                 # Views and assets
└── routes/                    # Application routes
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

1. **Google Maps** - Enter your Google Maps API key
2. **Payment Methods** - Configure Stripe, PayPal, or other gateways
3. **Push Notifications** - Set up FCM/OneSignal credentials
4. **Currencies** - Add supported currencies
5. **Social Auth** - Configure OAuth credentials

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
