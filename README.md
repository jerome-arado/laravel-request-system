# Laravel Request System

A Laravel-based web application developed for DevOps Laboratory 1 that demonstrates Laravel project setup using Composer, MySQL database integration, Git version control, and a basic DevOps workflow.

---

## Student Information

- **Name:** Arado, Jerome
- **Name:** Derit, Hugh
- **Course, Year, and Section: ** BSIT 4-3

---

## Software Requirements

- PHP 8.1 or higher
- Composer
- MySQL (via XAMPP)
- phpMyAdmin
- Node.js and npm
- Git
- Web browser

---

## Laravel Installation Instructions

1. Install Composer and make sure PHP is available in your system PATH.
2. Open a terminal and navigate to your web server directory (e.g., `C:\xampp\htdocs`).
3. Create a new Laravel project using Composer:

   ```bash
   composer create-project laravel/laravel laravel-request-system
   ```

4. Navigate into the project folder:

   ```bash
   cd laravel-request-system
   ```

5. Copy the environment file:

   ```bash
   cp .env.example .env
   ```

6. Generate the application key:

   ```bash
   php artisan key:generate
   ```

7. Configure your database credentials inside the `.env` file (see **Database Import Instructions** below).

---

## Database Name

```
laravel_request_system_db
```

---

## Database Import Instructions

1. Start XAMPP and open phpMyAdmin at `http://localhost/phpmyadmin`.
2. Create a new database named `laravel_request_system_db`.
3. Set the database connection in the `.env` file:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_request_system_db
   DB_USERNAME=your_local_username
   DB_PASSWORD=your_local_password
   ```

4. Run the migrations to create the required tables:

   ```bash
   php artisan migrate
   ```

---

## Commands Needed to Run the Project

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Then open the application in your browser at:

```
http://127.0.0.1:8000
```

---

## GitHub Repository Link

https://github.com/jerome-arado/laravel-request-system
