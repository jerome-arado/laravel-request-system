# Laravel Request System

A Laravel-based web application developed for DevOps Laboratory 1 that demonstrates Laravel project setup using Composer, MySQL database integration, Git version control, and a basic DevOps workflow.

---

## Student Information

- **Name:** Arado, Jerome
- **Name:** Derit, Hugh
- **Course, Year, and Section:** BSIT 4-3

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

## Request Table Fields

| Field | Type | Constraint |
|---|---|---|
| id | BIGINT UNSIGNED | Primary key, auto-increment |
| requester_name | VARCHAR(100) | Required |
| requester_email | VARCHAR(255) | Required |
| item_name | VARCHAR(150) | Required |
| quantity | INT UNSIGNED | Required, must be > 0 |
| purpose | TEXT | Required |
| status | VARCHAR(20) | Default: pending |
| created_at | TIMESTAMP | Nullable |
| updated_at | TIMESTAMP | Nullable |

## Migration Command

php artisan make:migration create_requests_table
php artisan migrate
php artisan migrate:status

## Steps to Verify the Table

1. Open phpMyAdmin at http://localhost/phpmyadmin
2. Select laravel_request_system_db
3. Click the requests table
4. Click Structure to verify columns and types
5. Click Browse to view sample rows

## User Stories

### Requester
As a requester, I want to submit a request for an item or service so that my needs are formally recorded and can be reviewed.

### Staff Reviewer
As a staff reviewer, I want to view and update the status of submitted requests so that I can approve or reject them efficiently.

### Record Keeper
As a record keeper, I want to browse and track all requests and their statuses so that I can maintain accurate records.
A simple Laravel-based request management system built as part of DevOps Laboratory 1. The project demonstrates Laravel setup, MySQL database integration, Git version control, and a basic DevOps workflow.

## Student Information
- **Complete Name:** [Arado, Jerome]
- **Course:** [BSIT 4-3]

## Software Requirements
- PHP >= 8.1
- Composer
- MySQL (via XAMPP)
- phpMyAdmin
- Node.js and npm
- Git

## Laravel Installation Instructions
1. Clone the repository:
   ```bash
   git clone https://github.com/jerome-arado/laravel-request-system.git
   cd laravel-request-system
