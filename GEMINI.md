# Ujian CBT - Project Instructions

This project is a Computer Based Test (CBT) platform built with **Laravel 11**. It supports two main roles: **Teacher** and **Student**, with role-based access control (RBAC) managed by `spatie/laravel-permission`.

## Project Overview

- **Purpose:** A web-based application for managing courses, questions, and conducting online exams.
- **Backend:** PHP 8.2+, Laravel 11.
- **Frontend:** Vue 3, Inertia.js, Tailwind CSS, Vite.
- **Authentication:** Laravel Breeze (Inertia/Vue stack).
- **Permissions:** Spatie Laravel Permission (Roles: `teacher`, `student`).
- **Database:** Migrations and seeders are provided for initial setup.

## Getting Started

### Prerequisites

- PHP 8.2 or higher
- Composer
- Node.js & pnpm
- MySQL or SQLite (check `.env`)

### Installation

1.  **Clone and Install Dependencies:**
    ```bash
    composer install
    pnpm install
    ```

2.  **Environment Setup:**
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Database Migration & Seeding:**
    ```bash
    php artisan migrate --seed
    ```

4.  **Frontend Build:**
    ```bash
    pnpm dev # For development
    # or
    pnpm build # For production
    ```

5.  **Run the Server:**
    ```bash
    php artisan serve
    ```

### Default Credentials (from `RolePermissionSeeder`)

- **Teacher:** `jackson@teacher.com` / `password`

## Development Conventions

- **Architecture:** Standard Laravel MVC pattern with a **Service Layer** (`app/Services`) for business logic.
- **Views:** Vue 3 components located in `resources/js/Pages`.
- **State Management:** Inertia.js for seamless server-side routing and data handling.
- **Styling:** Tailwind CSS utility classes.
- **Authorization:** Use `middleware('role:...')` in routes or `$page.props.auth` in Vue components for access control.
- **Redirection:** `RoleRedirect` middleware handles automatic redirection from `/` and `/dashboard` based on the user's role.
- **Middleware Aliases:**
    - `role`: `\Spatie\Permission\Middleware\RoleMiddleware::class`
    - `permission`: `\Spatie\Permission\Middleware\PermissionMiddleware::class`
    - `role_or_permission`: `\Spatie\Permission\Middleware\RoleOrPermissionMiddleware::class`

## Key Commands

| Task | Command |
| :--- | :--- |
| **Run Tests** | `php artisan test` |
| **Clear Cache** | `php artisan optimize:clear` |
| **Fresh Database** | `php artisan migrate:fresh --seed` |
| **Linting** | `vendor/bin/pint` |
| **Vite Dev** | `pnpm dev` |
| **Vite Build** | `pnpm build` |

## Directory Structure Highlights

- `app/Http/Controllers`: Controllers handling Inertia requests.
- `app/Services`: Business logic encapsulated in service classes (e.g., `AssessmentService`, `CourseService`).
- `app/Models`: Eloquent models (Category, Course, CourseQuestion, StudentAssessment, etc.).
- `database/migrations`: Schema definitions including assessment and answer tables.
- `resources/js/Pages`: Vue 3 page components organized by role (`Admin/` and `Student/`).
- `routes/web.php`: Route definitions with role-based and redirect middleware.

## Role-Based Workflows

### Teacher (Admin)
- Manage courses and course categories.
- Create and manage course questions (multiple choice).
- Enroll students in courses.
- View dashboard analytics and student lists.

### Student
- Browse enrolled courses.
- Start and take assessments.
- Real-time answer submission.
- View assessment results and rapport.
