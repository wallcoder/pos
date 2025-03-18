# Simple Point of Sale (POS) System

## Overview
This is a simple Point of Sale (POS) system created by Biakropuia MZU as part of the fulfillment of recruitment by Lailen Pvt Ltd. The project was built within a week using Filament and Laravel.

## Features
- User authentication and role-based access control
- Product and inventory management
- Stock and order management


## Technologies Used
- **Laravel** - Backend framework
- **Filament** - Admin panel and UI components


## Installation
### Prerequisites:
- PHP 8.0 or higher
- Composer
- MySQL database

### Steps to Install:
1. Clone the repository:
   ```sh
   git clone https://github.com/wallcoder/pos.git
   cd pos-system
   ```
2. Install dependencies:
   ```sh
   composer install
   ```
3. Copy environment file and configure database:
   ```sh
   cp .env.example .env
   ```
   Update `.env` with your database credentials.
4. Generate application key:
   ```sh
   php artisan key:generate
   ```
5. Run database migrations:
   ```sh
   php artisan migrate --seed
   ```
6. Serve the application:
   ```sh
   php artisan serve
   ```






## Contact
For any inquiries, reach out at contact@biakadev or biakropuia4@gmail.com.

