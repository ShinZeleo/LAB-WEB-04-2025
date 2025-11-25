# Product Management System

A Laravel-based application for managing products, categories, warehouses, and stock transfers.

## Features

- Product management (CRUD operations)
- Category management (CRUD operations)
- Warehouse management (CRUD operations)
- Stock management with transfer functionality
- Authentication with Laravel Breeze
- Search and pagination
- Database transactions for stock transfers
- Validation and error handling

## Setup Instructions

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- Node.js and npm

### Installation Steps

1. **Clone or create the project** (if you're setting up from scratch)

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Configure environment**
   ```bash
   cp .env.example .env
   ```

4. **Update .env with MySQL configuration**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=inventory_management
   DB_USERNAME=root
   DB_PASSWORD=
   ```

5. **Generate application key**
   ```bash
   php artisan key:generate
   ```

6. **Run migrations and seed database**
   ```bash
   php artisan migrate --seed
   ```

7. **Build assets**
   ```bash
   npm run build
   ```

8. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Login Credentials

After seeding, you can log in with:
- Email: `admin@example.com`
- Password: `password`

## Database Structure

The system consists of the following tables:

- `categories`: Product categories
- `warehouses`: Storage locations
- `products`: Product information
- `product_details`: Detailed product information (description, weight, size)
- `product_warehouse`: Pivot table for stock tracking

## Business Rules

1. **Stock Transfer Validation**: Ensure stock doesn't go below zero after transfer
2. **Foreign Key Constraints**: Proper relationships between entities
3. **Transaction Safety**: Stock transfers use database transactions for consistency
4. **Unique Constraints**: Product-Warehouse combinations are unique

## Functionality

- **Categories**: Create, read, update, delete categories
- **Warehouses**: Create, read, update, delete warehouses  
- **Products**: Create, read, update, delete products with detailed information
- **Stock**: View stock by warehouse, transfer stock between warehouses
- **Authentication**: All management features require login

## Project Structure

The project follows standard Laravel conventions:
- Controllers: `app/Http/Controllers/`
- Models: `app/Models/`
- Views: `resources/views/`
- Migrations: `database/migrations/`
- Seeds: `database/seeders/`
- Routes: `routes/web.php`

## Testing

To run tests:
```bash
php artisan test
```

## License

This project is open-source.