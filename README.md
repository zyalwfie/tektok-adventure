# Tektok Adventure

Tektok Adventure is a CodeIgniter 4 web application for managing an outdoor and camping equipment store. The application combines an online shop, customer checkout flow, admin dashboard, product and order management, cashier/POS transaction flow, payment proof upload, stock control, and PDF-based receipt/report generation.

This project was built as a portfolio project to demonstrate PHP web development skills using MVC architecture, database-driven business logic, role-based access control, form validation, file upload handling, transaction workflows, and report generation.

## Project Highlights

- Built with **PHP 8** and **CodeIgniter 4** using MVC-based structure.
- Implements separate workflows for public visitors, authenticated users, and admins.
- Uses **Myth/Auth** for authentication and role-based access control.
- Supports product catalog browsing, cart management, checkout, payment proof upload, and order history.
- Provides admin-side product, user, order, cashier, and sales report management.
- Generates PDF receipts and transaction reports using **Dompdf**.
- Applies database relationships across products, categories, carts, orders, order items, users, and payments.

## Tech Stack

| Area | Technology |
|---|---|
| Backend | PHP 8, CodeIgniter 4 |
| Architecture | MVC, CodeIgniter Routing, Controllers, Models, Views |
| Authentication | Myth/Auth |
| Database | MySQL / MariaDB |
| Frontend | HTML, CSS/SCSS, JavaScript |
| PDF Generation | Dompdf |
| Dependency Management | Composer |
| Development Tools | Git, GitHub, VS Code |

## Main Features

### Public Storefront

- Landing page for store branding and featured products.
- Product catalog page.
- Product detail page with related products.
- Category-based product organization.
- Cart counter for authenticated users.

### Customer Features

- User registration and login via Myth/Auth.
- Add products to cart.
- Increase or decrease cart item quantity.
- Remove products from cart.
- Checkout and create orders from cart items.
- Upload payment proof with validation.
- View order history and order details.
- Manage user profile and change password.

### Admin Dashboard

- Dashboard summary for completed orders, pending orders, total sales, and user count.
- Product management with create, read, update, and delete operations.
- Product image upload with file type and file size validation.
- Category-based product data handling.
- User management for customer accounts.
- Order management and order detail review.
- Payment proof review.
- Order status update.
- Stock deduction when an order is approved.

### Cashier / POS Flow

- Admin cashier page for direct in-store purchases.
- Add available products to cashier cart.
- Validate stock before checkout.
- Create completed orders from cashier transactions.
- Deduct product stock after successful transaction.
- Generate printable receipt view.
- Export receipt to PDF.

### Sales Reports

- Filter successful transactions by date range.
- Calculate total sales from filtered orders.
- Preview transaction report.
- Export sales report to PDF.

## What This Project Demonstrates

This project highlights practical backend and fullstack web development skills, especially for PHP Programmer roles.

### PHP and CodeIgniter Development

- Structured application logic using CodeIgniter controllers, models, views, and route groups.
- Implemented business workflows for shopping cart, checkout, payment, order approval, cashier transactions, and reporting.
- Applied reusable model-based database operations.

### MVC and Routing

- Organized public, user, and admin routes using CodeIgniter route groups.
- Applied login and role-based filters to protect cart, user dashboard, and admin dashboard areas.
- Separated business responsibilities across Landing, User, and Admin controllers.

### Database-Driven Application Logic

- Designed workflows around relational data such as products, categories, carts, orders, order items, payments, and users.
- Used query builder joins to retrieve product, order, user, and payment information.
- Managed order item creation and stock updates based on transaction status.

### Authentication and Authorization

- Integrated Myth/Auth for login and user identity management.
- Implemented role-based access between admin and user dashboards.
- Added profile update and password change flows.

### File Upload and Validation

- Validated uploaded product images by extension and size.
- Validated payment proof uploads by MIME type and size.
- Generated random file names for uploaded files to avoid naming conflicts.

### PDF Generation

- Created receipt PDF output for cashier transactions.
- Created report PDF output for sales transaction reports.
- Used Dompdf to convert HTML-based report templates into printable documents.

## Repository Structure

```txt
app/
├── Config/
│   └── Routes.php
├── Controllers/
│   ├── Admin.php
│   ├── Landing.php
│   └── User.php
├── Database/
│   └── Migrations/
├── Models/
│   ├── CartModel.php
│   ├── CategoryModel.php
│   ├── OrderItemModel.php
│   ├── OrderModel.php
│   ├── PaymentModel.php
│   └── ProductModel.php
└── Views/
    ├── dashboard/
    └── landing/

public/
├── img/
└── assets/
```

## Installation

### Prerequisites

Make sure your environment has the following installed:

- PHP 8.1 or higher
- Composer
- MySQL or MariaDB
- Web server such as Apache, Nginx, or CodeIgniter local development server

### Setup Steps

1. Clone this repository.

```bash
git clone https://github.com/zyalwfie/tektok-adventure.git
cd tektok-adventure
```

2. Install dependencies.

```bash
composer install
```

3. Create the environment file.

```bash
cp env .env
```

4. Configure the application URL and database connection in `.env`.

```env
CI_ENVIRONMENT = development
app.baseURL = 'http://localhost:8080/'

database.default.hostname = localhost
database.default.database = tektok_adventure
database.default.username = root
database.default.password =
database.default.DBDriver = MySQLi
database.default.port = 3306
```

5. Create the database.

```sql
CREATE DATABASE tektok_adventure;
```

6. Run database migrations.

```bash
php spark migrate
```

7. Start the development server.

```bash
php spark serve
```

8. Open the application in your browser.

```txt
http://localhost:8080
```

## Portfolio Relevance

This project is suitable to showcase for PHP Programmer or Backend Web Developer positions because it demonstrates:

- PHP-based web application development.
- CodeIgniter 4 MVC implementation.
- CRUD operations for real business entities.
- Authentication and role-based access control.
- MySQL relational data handling.
- Query builder usage and table joins.
- Product, order, cart, payment, cashier, and reporting workflows.
- File upload validation.
- PDF receipt and report generation.
- GitHub-based project documentation.

## Future Improvements

- Add seeders for demo admin, user, category, and product data.
- Add screenshots for landing page, shop page, admin dashboard, cashier page, and report page.
- Add unit or feature tests for checkout, order approval, and stock deduction.
- Improve transaction handling using database transactions for checkout and cashier flows.
- Add pagination and search to product, order, and user tables.
- Add REST API endpoints for product and order resources.
- Add deployment instructions for shared hosting or Linux server environments.

## Author

**Ziyat Al Wafi**  
GitHub: [github.com/zyalwfie](https://github.com/zyalwfie)
