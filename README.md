<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# Roles and Permissions API

## Overview
This project provides a RESTful API to manage users, roles, and permissions. The API includes secure token-based authentication using **Laravel Passport**, ensuring scalability and clean architecture with the **Repository Pattern**.

---

## Features
1. **User Management**:
   - Users can have multiple roles and permissions.
   - Supports CRUD operations for users.

2. **Role Management**:
   - Roles can have multiple permissions.
   - Assign/revoke roles and permissions to/from users.

3. **Permission Management**:
   - Fine-grained access control with permission-based authorization.

4. **Authentication**:
   - Token-based authentication with **Laravel Passport**.

5. **Authorization Middleware**:
   - Protects routes using roles and permissions.

---

## Technologies
- Laravel 10+
- Spatie Laravel Permission
- Laravel Passport
- PHP 8.1+

---

## Installation

### 1. Clone the Repository
```bash
git clone <repository-url>
cd <repository-folder>
```
### 2. Install Dependencies
```bash
composer install
or
composer install --ignore-platform-reqs
```
### 3. Configure Environment
Copy .env.example to .env and update the database 
configuration:
```bash
cp .env.example .env
```
Update the following in .env:
```bash
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```
### 4. Generate Application Key
```bash
php artisan key:generate
```
### 5. Run Migrations
You Can Run Migration From **Api Collection** . Send **Response** to **Migration Request** inside the **Configuration Folder** of **Api Collection**. 

Or
```bash
php artisan migrate

```
### 6. Install Passport
```bash
php artisan passport:install
```

### 7. Seed the Database
Seed roles, permissions, and default admin user. You Can Seed Them From **Api Collection** . Send **Response** to **DatabaseSeeder** inside the **Configuration Folder** of **Api Collection**. 

Or
```bash
php artisan db:seed
```
### 8. Start the Server

```bash
php artisan serve
```
