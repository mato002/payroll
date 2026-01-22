# MatechPay

A comprehensive payroll management system built with Laravel, designed to streamline payroll processing, employee management, and compliance reporting for businesses of all sizes.

## About MatechPay

MatechPay is a modern payroll management system that automates payroll calculations, tax compliance, and employee lifecycle management. Built with Laravel, it provides a robust, scalable solution for managing payroll operations.

## Features

- **Smart Payroll Engine** - Automated payroll calculations with full audit trails
- **Employee Lifecycle Management** - Track hiring, promotions, salary changes, and terminations
- **Multi-Company Support** - Run payroll for multiple entities with clean data separation
- **Compliance Reporting** - Generate tax summaries, pension reports, and annual payroll summaries
- **Role-Based Access Control** - Granular permissions for payroll operations
- **Subscription Management** - Flexible billing plans with invoice management
- **Modern UI** - Responsive design with dark mode support

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL/PostgreSQL or SQLite
- Laravel 11.x

## Installation

1. Clone the repository:
```bash
git clone <repository-url>
cd payroll-system
```

2. Install PHP dependencies:
```bash
composer install
```

3. Install Node dependencies:
```bash
npm install
```

4. Copy environment file:
```bash
cp .env.example .env
```

5. Generate application key:
```bash
php artisan key:generate
```

6. Configure your database in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=matechpay
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

7. Run migrations:
```bash
php artisan migrate
```

8. Seed the database (optional):
```bash
php artisan db:seed
```

9. Build frontend assets:
```bash
npm run build
```

10. Start the development server:
```bash
php artisan serve
```

## Configuration

### Application Name

The application name is configured in `config/app.php` and can be overridden in your `.env` file:

```env
APP_NAME=MatechPay
```

### Multi-Tenancy

MatechPay supports multi-tenant architecture. See `MULTI_TENANCY_USAGE.md` for detailed configuration.

### Billing

Configure billing settings in `config/billing.php`. See `SECURITY_IMPLEMENTATION.md` for security best practices.

## Documentation

- [Multi-Tenancy Usage Guide](MULTI_TENANCY_USAGE.md)
- [Company Switching Guide](COMPANY_SWITCHING_GUIDE.md)
- [Reporting Architecture](REPORTING_ARCHITECTURE.md)
- [Security Implementation](SECURITY_IMPLEMENTATION.md)
- [Design System](DESIGN_SYSTEM.md)

## License

This project is proprietary software. All rights reserved.

## Support

For support and inquiries, please contact the development team.
