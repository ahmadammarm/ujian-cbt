# Naiju - Computer Based Test Platform

Naiju is a simple modern mock Computer Based Test (CBT) platform. Developed with **Laravel 11**, **Inertia.js**, and **Vue 3**, it delivers a seamless, SPA-like examination experience while maintaining strict server-side security standards and resource isolation.

---

## Core Capabilities

### Teacher (Admin) Experience
- **Granular Course Control:** Complete lifecycle management of courses including metadata, categorization, and visual branding.
- **Advanced Question Bank:** Orchestrate complex multiple-choice assessments with up to 50 questions per course.
- **Resource Ownership:** Private environment architecture where teachers only access and manage their own curated content.
- **Engagement Analytics:** Real-time monitoring of student enrollment and platform-wide performance metrics.

### Student Experience
- **Progress Tracking:** Unified dashboard showing enrollment status, average scores, and recent assessment history.
- **Immersive Testing:** Real-time, interactive examination interface featuring automated countdown timers and instant answer persistence.
- **Performance Rapport:** Instant generation of detailed results and scoring reports upon test completion.
- **Integrity Focused:** Client-side data obfuscation prevents access to correct answer keys during active sessions.

---

## Security & Architecture

The application is hardened following senior-level security standards to ensure data integrity and platform stability:

- **Global Throttling:** Multi-layered rate limiting (60 req/min global, 10 req/min for high-stakes actions) to mitigate DoS and brute-force attempts.
- **Browser-Level Hardening:** Custom security middleware enforcing strict **Content Security Policy (CSP)**, X-Frame-Options (Clickjacking protection), and XSS blocking.
- **Multi-Tenant Isolation:** Resource-level authorization ensuring strict data privacy between independent teachers.
- **Universal Mass-Assignment Protection:** Strict `$fillable` allow-lists enforced across 100% of the Eloquent model layer.
- **Service Layer Architecture:** Business logic is encapsulated in `app/Services`, ensuring thin controllers and highly testable code.

---

## Technical Stack

| Layer | Technology |
| :--- | :--- |
| **Backend** | PHP 8.2+ / Laravel 11 |
| **Frontend** | Vue 3 / Inertia.js / Tailwind CSS |
| **Package Manager** | **PNPM** |
| **Build Tool** | Vite |
| **Database** | MySQL / SQLite |
| **Authorization** | Spatie Laravel Permission |

---

## Installation & Setup

### Prerequisites
- PHP 8.2 or higher, always on the latest patched release of your branch (verified on PHP 8.5.12)
- PHP extensions: `mbstring`, `openssl`, `curl`, `fileinfo`, `pdo_mysql`, `zip`, `intl`, `gd`, `sodium`
- **PNPM** (`npm install -g pnpm`)
- Composer
- Database (MySQL/SQLite)

> **Security note:** PHP releases occasionally ship fixes for serious vulnerabilities, including remote code execution (RCE). Run `php -v` and compare it with the latest release on [php.net](https://www.php.net/downloads) before deploying, and upgrade outdated installs. Keep `composer.lock` dependencies up to date as well.

### 1. Dependency Management
```bash
composer install
pnpm install
```

### 2. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```
*Configure your database and app URL settings within the `.env` file.*

### 3. Database Initialization
```bash
php artisan migrate --seed
```

### 4. Asset Orchestration
```bash
pnpm dev   # Start Vite development server
# OR
pnpm build # Compile for production
```

### 5. Launch
```bash
php artisan serve
```

---

## Development Reference

### Directory Structure
- `app/Http/Controllers`: Inertia-ready request handlers.
- `app/Services`: Core domain logic (Throttling, Grading, Resource Management).
- `app/Models`: Hardened data structures.
- `resources/js/Pages`: Role-specific Vue 3 components (`Admin/` vs `Student/`).
- `routes/web.php`: Polished, group-based routing with integrated rate limiting.

### Key Commands
| Task | Command |
| :--- | :--- |
| **Clear Caches** | `php artisan optimize:clear` |
| **Fix Styling** | `vendor/bin/pint` |
| **Re-Seed DB** | `php artisan migrate:fresh --seed` |
