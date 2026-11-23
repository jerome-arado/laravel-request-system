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
- MySQL (via XAMPP or Laragon)
- phpMyAdmin
- Node.js and npm
- Git
- Web browser

---

## Laravel Installation Instructions

1. Install Composer and make sure PHP is available in your system PATH.
2. Open a terminal and navigate to your web server directory (e.g., `C:\laragon\www`).
3. Create a new Laravel project using Composer:
   ```
   composer create-project laravel/laravel laravel-request-system
   ```
4. Navigate into the project folder:
   ```
   cd laravel-request-system
   ```
5. Copy the environment file:
   ```
   cp .env.example .env
   ```
6. Generate the application key:
   ```
   php artisan key:generate
   ```
7. Configure your database credentials inside the `.env` file.

---

## Database Name

```
laravel_request_system_db
```

---

## Database Import Instructions

1. Start XAMPP or Laragon and open phpMyAdmin at `http://localhost/phpmyadmin`.
2. Create a new database named `laravel_request_system_db`.
3. Set the database connection in the `.env` file:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel_request_system_db
   DB_USERNAME=your_local_username
   DB_PASSWORD=your_local_password
   ```
4. Run the migrations to create the required tables:
   ```
   php artisan migrate
   ```

---

## Commands Needed to Run the Project

```
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

---

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

---

## Migration Command

```
php artisan make:migration create_requests_table
php artisan migrate
php artisan migrate:status
```

---

## Steps to Verify the Table

1. Open phpMyAdmin at http://localhost/phpmyadmin
2. Select laravel_request_system_db
3. Click the requests table
4. Click Structure to verify columns and types
5. Click Browse to view sample rows

---

## User Stories

### Requester
As a requester, I want to submit a request for an item or service so that my needs are formally recorded and can be reviewed.

### Staff Reviewer
As a staff reviewer, I want to view and update the status of submitted requests so that I can approve or reject them efficiently.

### Record Keeper
As a record keeper, I want to browse and track all requests and their statuses so that I can maintain accurate records.

---

## Laboratory 3 File Responsibilities

| File | Maintainer |
|---|---|
| app/Policies/ServiceRequestPolicy.php | Driver |
| app/Http/Controllers/ServiceRequestController.php | Driver |
| routes/web.php | Driver |
| resources/views/requests/* | Driver |
| tests/Feature/ServiceRequestTest.php | Reviewer |
| README.md | Driver + Reviewer |

**Policy maintainer:** Driver
**Controller maintainer:** Driver
**Routes maintainer:** Driver
**Views maintainer:** Driver
**Tests maintainer:** Reviewer

**Denial response policy:** This project returns **404 (Not Found)** for another student's record to avoid disclosing that the record exists.

---

## Laboratory 3 Verification

Verification instruction: Test student ownership and deny access to another student's request.
Verification instruction: Test Administrator Access and Administrator-Only Status Updates.


---

## Release Process (Lab 8)

### Environments
| Environment | Purpose | Notes |
|---|---|---|
| Development | Local editing and debugging | Laragon, `APP_DEBUG=true` |
| Test | Automated CI on every push | GitHub Actions `ci.yml` |
| Staging | Production-like verification | `http://laravel-request-staging.test`, `APP_DEBUG=false`, required reviewer on the `staging` environment |
| Production | Real users | Not used in this lab |

### Release Checklist
Every release requires all of the following before promotion:

- Versioned tag and commit SHA
- Artifact digest (SHA256)
- CI green on the exact commit being deployed
- Migration plan stating whether a schema change is required
- Named approver from the `staging` environment's required-reviewer list
- Defined smoke tests (see below)
- A concrete rollback trigger (for example, the request-creation smoke test fails)

### Deploying a Release

1. Dispatch `.github/workflows/deploy-staging.yml` **from `main`**, with the `version` input set to the release tag. Do not dispatch at the tag itself — tags cut before the `workflow_dispatch` trigger was added will fail with "workflow does not exist".
2. The job pauses on the `staging` environment. The designated reviewer verifies:
   - CI status on the exact commit
   - The `Commit:` line in the **Verify release artifact** step matches the release tag
   - The migration plan
3. Reviewer approves; the run completes.
4. The supplied workflow's deployment step is a **simulation** (it echoes the target but does not copy files). The approved artifact is therefore promoted to the staging target manually, using the exact commit recorded in the run's Verify step. Approval, artifact identity, and post-promotion live revision are verified separately for each release.
5. Run the smoke tests.

### Smoke Tests
| # | Test | Expected |
|---|---|---|
| 1 | Health and revision | `GET /up` returns 200 and the running revision matches the release record |
| 2 | Student login | Test student signs in and reaches `/requests` |
| 3 | Request creation | Student creates an HDMI adapter request labelled `STAGE-LIB-08` and reopens the saved record |
| 4 | Administrator status update | Test administrator changes the request to an allowed status |
| 5 | Student restriction | The student account cannot perform the administrative status change (403) |

### Recovery Result — Lab 8

- **Faulty release:** `v1.4.1-lab-fault` — commit `f7ff986cdba34965d1a3258ace5ab2c0d6e518e5`. The fault introduces `abort(503, 'Request submission temporarily unavailable.')` in `app/Http/Controllers/ServiceRequestController.php`, so the request form is unavailable while the rest of the application stays up.
- **Failure observed:** Request-creation smoke test returned **503 Service Unavailable** at `/requests/create` for an authenticated student. This met the documented rollback trigger.
- **Restored release:** `v1.0.0` — commit `856a86e4915e5ca7aa211f9eede9ea5681e33bd3`.
- **Outcome:** All five smoke tests passed after rollback. The `STAGE-LIB-08` record (request ID 1) remained present throughout, confirming that an artifact rollback does not affect persisted data.
- **Database note:** Replacing the application artifact does not roll back the database schema or its records. A genuine database recovery is a separate procedure: restore a verified snapshot to a confirmed recovery point, apply migrations to the schema version required by the target release, and reconcile rows written between the snapshot and the rollback point using application and audit logs. `php artisan migrate:rollback` alone is not an acceptable recovery method because it reverses schema changes without restoring lost data.

### Workflow Run References
| Release | Run |
|---|---|
| Known-good `v1.0.0` | https://github.com/jerome-arado/laravel-request-system/actions/runs/45082602955 |
| Faulty `v1.4.1-lab-fault` | https://github.com/jerome-arado/laravel-request-system/actions/runs/45096838553 |
| Rollback `v1.0.0` | https://github.com/jerome-arado/laravel-request-system/actions/runs/45115776052 |

### Operational Notes
- The `staging` environment requires reviewer approval (currently: Hugh Derit).
- CI status on the exact commit is verified before approval, not assumed from `main`.
- Manual promotion after approval is expected for this lab because the supplied workflow simulates the deploy step. The promoted commit is always the one recorded in the run's Verify step.
- Rollback decision for Lab 8 was made at 1:08 on 23 November 2026.
- Reviewer verification recorded on 1:13.