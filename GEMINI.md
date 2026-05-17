# Ujian CBT - Project Instructions

This project is a Computer Based Test (CBT) platform built with **Laravel 11**. It supports two main roles: **Teacher** and **Student**, with role-based access control (RBAC) managed by `spatie/laravel-permission`.

## Project Overview

- **Purpose:** A web-based application for managing courses, questions, and conducting online exams.
- **Backend:** PHP 8.2+, Laravel 11.
- **Frontend:** Vue 3, Inertia.js, Tailwind CSS, Vite.
- **Dependencies:** Chart.js for analytics, Spatie Permissions for RBAC.
- **Authentication:** Laravel Breeze (Inertia/Vue stack).

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & pnpm
- MySQL or SQLite (check `.env`)

### Installation

1.  **Install Dependencies:**
    ```bash
    composer install
    pnpm install
    ```

2.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Database Setup:**
    ```bash
    php artisan migrate --seed
    ```
    *Note: Seeding includes `PlatformDataSeeder` for realistic demo data (50 students, 10 courses, assessments).*

4.  **Frontend Build:**
    ```bash
    pnpm dev # For development
    # or
    pnpm build # For production
    ```

## AI Agent Development Standards

All automated or manual development must strictly adhere to the project's technical manifests located in `.gemini/rules/`. These rules take precedence over general defaults.

*   **Backend Standards:** See `.gemini/rules/backend-pattern.md`.
*   **Frontend Standards:** See `.gemini/rules/frontend-pattern.md`.

## Core Architectural Patterns

### Backend: The Triad Pattern
We enforce a strict separation of concerns through three layers:
1.  **Requests (`app/Http/Requests`):** Solely responsible for data validation and structural integrity.
2.  **Controllers (`app/Http/Controllers`):** Thin orchestrators that receive requests, invoke services, and return Inertia responses.
3.  **Services (`app/Services`):** The domain layer containing all business logic, complex queries, and persistence operations.

### Frontend: Atomic Design
UI components are organized in `resources/js/Components` by their complexity:
*   **Atoms:** Stateless basic elements (Buttons, Badges).
*   **Molecules:** Simple functional groups (SearchInputs, FormFields).
*   **Organisms:** Complex sections (DataTables, ChartCards).
*   **Templates/Layouts:** Page structural containers.

## Role-Based Workflows

### Teacher (Admin)
- **Overview:** Monitor platform-wide metrics (Total Students, Courses, Assessments).
- **Course Management:** CRUD operations for courses, categories, and questions.
- **Student Management:** View paginated students with debounced search, track average scores, and manage account status (Suspend/Activate).
- **Analytics:** Visualize enrollment trends and course performance leaderboards.

### Student
- **Learning:** Browse enrolled courses and start assessments.
- **Assessment:** Real-time answer submission with auto-scoring.
- **Reporting:** View detailed results and performance rapport.

## Key Commands

| Task | Command |
| :--- | :--- |
| **Run Tests** | `php artisan test` |
| **Clear Cache** | `php artisan optimize:clear` |
| **Fresh Setup** | `php artisan migrate:fresh --seed` |
| **Code Linting** | `vendor/bin/pint` |
| **Dev Server** | `php artisan serve` |

## Default Credentials

- **Teacher:** `jackson@teacher.com` / `password`
- **Students:** `student1@example.com` through `student50@example.com` / `password`
