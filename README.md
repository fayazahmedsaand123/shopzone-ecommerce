# ShopZone - Laravel 12 E-Commerce Management System

A full-featured E-Commerce platform built with Laravel 12, PHP 8.2, and MySQL.
The system includes a public storefront and a complete admin panel with AJAX-powered interactions.

---

## Features

### Storefront (Customer Side)
- Light / Dark theme toggle
- AJAX live search with product filters
- Product listing with category and brand filters
- Product detail page
- Shopping cart (AJAX)
- Wishlist (AJAX)
- Checkout with order placement
- Order history and order detail view
- Customer dashboard
- Contact page and FAQ page

### Admin Panel
- Secure admin authentication
- Dashboard with statistics
- Product management (create, edit, delete, image upload)
- Category management
- Brand management (54 brands)
- Order management with status updates
- Customer messages management
- Role-based access control

---

## Tech Stack

| Technology     | Version  |
|----------------|----------|
| PHP            | 8.2      |
| Laravel        | 12       |
| MySQL          | 8.0      |
| Bootstrap      | 5        |
| JavaScript     | ES6      |
| AJAX           | jQuery   |
| Git            | Latest   |

---

## Project Stats

- Total Products: 127
- Total Brands: 54
- Admin Panel: Full CRUD
- Theme: Light / Dark mode supported

---

## Installation

Follow these steps to run the project locally.

**1. Clone the repository**
```bash
git clone https://github.com/fayazahmedsaand123/shopzone-ecommerce.git
cd shopzone-ecommerce
```

**2. Install dependencies**
```bash
composer install
npm install
```

**3. Environment setup**
```bash
cp .env.example .env
php artisan key:generate
```

**4. Configure database**

Open `.env` and update:
```
DB_DATABASE=shopzone
DB_USERNAME=root
DB_PASSWORD=
```

**5. Run migrations and seeders**
```bash
php artisan migrate --seed
```

**6. Storage link**
```bash
php artisan storage:link
```

**7. Run the application**
```bash
php artisan serve
```

Visit: http://127.0.0.1:8000

---

## Default Admin Credentials

```
Email:    admin@shopzone.com
Password: password
```

---

## Developer

**Fayaz Ahmed Saand**
Full Stack Laravel Developer
Hyderabad, Sindh, Pakistan

- GitHub: [github.com/fayazahmedsaand123](https://github.com/fayazahmedsaand123)
- Portfolio: [fayazahmedsaand123.github.io/portfolio](https://fayazahmedsaand123.github.io/portfolio)
- Email: Fayazahmedsaand93@gmail.com
- Fiverr: [fiverr.com/fayazahmed13](https://fiverr.com/fayazahmed13)
- Upwork: [upwork.com/freelancers/~014a51348826db402e](https://upwork.com/freelancers/~014a51348826db402e)

---

## License

This project is open source and available under the [MIT License](LICENSE).
