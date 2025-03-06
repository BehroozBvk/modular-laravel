# Baraeim - Educational Platform

A modern educational platform built with Laravel 11, featuring a modular architecture and comprehensive API documentation.

## 📋 Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Technology Stack](#technology-stack)
- [Project Structure](#project-structure)
- [Requirements](#requirements)
- [Installation](#installation)
- [Development](#development)
- [API Documentation](#api-documentation)
- [Log Viewer](#log-viewer)
- [Testing](#testing)
- [Deployment](#deployment)
- [Contributing](#contributing)
- [License](#license)

## 🌟 Overview

Baraeim is an educational platform designed to connect students, teachers, and parents in a seamless learning environment. The application follows Domain-Driven Design (DDD) principles with a modular architecture, ensuring clean code and separation of concerns.

## ✨ Features

- **User Management**: Authentication, authorization, and user profiles
- **Student Management**: Student registration, profiles, and progress tracking
- **Teacher Management**: Teacher profiles and lesson management
- **Parent Management**: Parent accounts linked to students
- **Lesson Management**: Create, update, and manage educational content
- **About Page**: Dynamic content management for the about page
- **Competitions**: Educational competitions and challenges
- **Activities**: Interactive learning activities
- **Articles**: Educational articles and resources
- **Frequently Asked Questions**: Dynamic FAQ management
- **Home Page**: Customizable home page content
- **Multi-language Support**: Fully translatable content
- **Log Management**: Integrated Log Viewer for easy debugging and monitoring

## 🛠️ Technology Stack

- **Backend**: PHP 8.2+, Laravel 11
- **Database**: MySQL/SQLite
- **API**: RESTful API with Laravel Passport
- **Documentation**: Scribe API Documentation
- **Modules**: Laravel Modules (nwidart/laravel-modules)
- **Translations**: Astrotomic Laravel Translatable
- **Development Tools**: Laravel Pint, PHPStan, Rector, PHP CS Fixer
- **Testing**: Pest PHP, PHPUnit
- **Monitoring**: Laravel Telescope, OPcodes Log Viewer
- **Code Quality**: PHPMD, Duster, ESLint

## 📁 Project Structure

The application follows a modular architecture with Domain-Driven Design principles:

```
Modules/
├── Core/                 # Core functionality and base classes
├── User/                 # User management
├── Student/              # Student management
├── Teacher/              # Teacher management
├── StudentParent/        # Parent management
├── Lesson/               # Lesson management
├── About/                # About page content
├── Competition/          # Educational competitions
├── Activity/             # Learning activities
├── Article/              # Educational articles
├── FrequentlyAskedQuestion/ # FAQ management
├── HomePage/             # Home page content
└── ...
```

Each module follows a clean architecture pattern:

```
Module/
├── Domain/               # Domain models, DTOs, and events
│   ├── Models/
│   ├── DTOs/
│   └── Events/
├── Application/          # Application services and repositories
│   ├── Services/
│   └── Repositories/
└── Infrastructure/       # Controllers, requests, and resources
    ├── Http/
    │   ├── Controllers/
    │   ├── Requests/
    │   └── Resources/
    └── Database/
        ├── Migrations/
        └── Seeders/
```

## 📋 Requirements

- PHP 8.2 or higher
- Composer
- Node.js and NPM
- MySQL or SQLite
- Git

## 🚀 Installation

Follow these steps to set up the project locally:

1. **Clone the repository**

```bash
git clone https://github.com/your-username/baraeim.git
cd baraeim
```

2. **Install PHP dependencies**

```bash
composer install
```

3. **Set up environment variables**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Configure your database**

Edit the `.env` file and set your database connection:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=baraeim
DB_USERNAME=root
DB_PASSWORD=
```

For SQLite (development):

```
DB_CONNECTION=sqlite
# Comment out other DB_ variables
```

5. **Run migrations and seeders**

```bash
php artisan migrate --seed
```

6. **Install Passport**

```bash
php artisan passport:install
```

7. **Install frontend dependencies**

```bash
npm install
npm run dev
```

8. **Publish Log Viewer assets**

```bash
php artisan log-viewer:publish
```

9. **Generate API documentation**

```bash
php artisan scribe:generate
```

## 💻 Development

### Starting the development server

```bash
php artisan serve
```

### Running the queue worker

```bash
php artisan queue:work
```

### Watching for frontend changes

```bash
npm run dev
```

### Running all services concurrently

```bash
composer dev
```

### Clearing caches

```bash
composer clear-all
```

### Refreshing the database

```bash
composer db-all
```

### Setting up the project (all-in-one)

```bash
composer setup
```

## 📚 API Documentation

API documentation is generated using Scribe and can be accessed at:

```
http://localhost:8000/docs
```

To regenerate the documentation after making changes:

```bash
php artisan scribe:generate
```

## 📊 Log Viewer

Baraeim integrates OPcodes's Log Viewer for elegant and powerful log management. It provides a user-friendly interface to view, search, and filter Laravel logs and other log types.

### Features

- View all Laravel logs with a beautiful UI
- Search and filter log entries
- Dark mode support
- Mobile-friendly interface
- Download & delete log files directly from the UI

For detailed information and usage instructions, see [LOG-VIEWER.md](LOG-VIEWER.md).

### Quick Access

Log Viewer is available at:

```
http://localhost:8000/log-viewer
```

## 🧪 Testing

Run tests using Pest:

```bash
./vendor/bin/pest
```

## 🚢 Deployment

### Production setup

1. Set up your production environment
2. Clone the repository
3. Install dependencies with `composer install --no-dev --optimize-autoloader`
4. Configure environment variables
5. Run migrations with `php artisan migrate --force`
6. Install Passport with `php artisan passport:install`
7. Build frontend assets with `npm ci && npm run build`
8. Generate API documentation with `php artisan scribe:generate`
9. Optimize the application with `php artisan optimize`

### Deployment script

You can use the following command to optimize the application for production:

```bash
composer setup
```

## 🤝 Contributing

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add some amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

## 📄 License

This project is licensed under the MIT License - see the LICENSE file for details.
