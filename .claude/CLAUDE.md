# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Mandatory Development Rules & Guidelines
All AI agents and developers working on this repository **MUST strictly load and adhere to the project standards** located in the `.claude/rules/` directory:
- **Backend Standards**: `.claude/rules/backend-pattern.md`
  - Strict Request-Controller-Service Triad (Form Request validation, thin controllers, domain services).
  - Explicit relationship return types, universal `$fillable` mass-assignment protection, and database transactions (`DB::transaction`) for multi-write operations.
  - DRY service queries and class constants for thresholds and status codes (zero hardcoded numbers or strings).
- **Frontend Standards**: `.claude/rules/frontend-pattern.md`
  - Atomic Design hierarchy (`Atoms/`, `Molecules/`, `Organisms/`, `Templates/`).
  - Vue 3 Composition API with `<script setup>`, explicit `defineProps`, and Inertia.js form/navigation management.
  - Tailwind CSS utility styling with Poppins typography and project color tokens (no arbitrary inline styles or isolated custom `<style>` overrides).

---

## Development Commands

### Dependency Management
- PHP dependencies: `composer install`
- Node dependencies: `pnpm install` (always use pnpm as the package manager)

### Development Servers
- Backend server: `php artisan serve`
- Vite frontend dev server: `pnpm dev`
- Production asset build: `pnpm build`

### Testing
- Run all tests: `php artisan test` or `vendor/bin/phpunit`
- Run a specific test file: `php artisan test tests/Feature/Auth/AuthenticationTest.php`
- Run a specific test method: `php artisan test --filter test_login_screen_can_be_rendered`
- Run by testsuite: `php artisan test --testsuite=Feature` or `php artisan test --testsuite=Unit`

### Database & Seeding
- Run migrations: `php artisan migrate`
- Fresh migration with seeders: `php artisan migrate:fresh --seed`
- Run specific seeder: `php artisan db:seed --class=RolePermissionSeeder`
- Default test credentials seeded:
  - Teacher: `jackson@teacher.com` / `password`
  - Students: `student1@example.com` through `student50@example.com` / `password`

### Code Style & Maintenance
- Fix backend code style: `vendor/bin/pint`
- Clear application cache: `php artisan optimize:clear`

---

## Brand Architecture & Design System

### Brand Identity
- **Primary Brand**: Naiju
- **Full Tagline / Lockup**: `Naiju — Platform Ujian & Asesmen Digital` (or `Naiju CBT`)
- **Brand Spaces**:
  - Teacher Workspace: `Naiju Studio` (`Naiju Studio · Pengajar`)
  - Student Portal: `Naiju Exam` (`Naiju Exam · Portal Siswa`)
- **Emblem**: Geometric 'N' monogram vector (`ApplicationLogo.vue`)

### Core Palette Tokens
- **Terracotta Orange (`#D95300`)**: Primary brand identity, teacher space primary accents, critical action CTAs.
- **Cobalt Blue (`#2B82FE`)**: Student portal accents, active navigation states, interactive highlights.
- **Obsidian Black (`#0A090B`) & Dark Surface (`#111116`)**: High-contrast typography, dark panels, structured surface elements.

---

## Architecture & Code Structure

### Technology Stack
- Backend: Laravel 11, PHP 8.2+
- Frontend: Inertia.js v3, Vue 3 (Composition API / `<script setup>`), Tailwind CSS, Vite
- Roles & Permissions: Spatie Laravel Permission
- Package Manager: PNPM

### Role-Based Architecture & Access Control
- User roles: `teacher` and `student`.
- Route isolation (`routes/web.php`):
  - Teacher routes are grouped under `role:teacher` (`/dashboard/overview`, `/dashboard/courses`, `/dashboard/students`, `/dashboard/analytics`).
  - Student routes are grouped under `role:student` (`/dashboard/learning/*`).
- Role routing middleware:
  - `RoleRedirect` automatically directs authenticated users hitting `/` or `/dashboard` to `dashboard.overview` if they have the `teacher` role, or to `dashboard` (student dashboard) otherwise.
- Resource ownership & isolation:
  - Teachers only manage their own courses via `$user->teacherCourses()` (`teacher_id` column on `courses`).
  - Students can only access courses they are enrolled in via the `course_students` pivot table.

### Assessment Lifecycle, Integrity & Proctoring
- Examination flow (`app/Services/AssessmentService.php`, `LearningController.php`, `Take.vue`):
  - **Prerequisite Fullscreen Lock**: `ProctoringModal.vue` requires students to activate Fullscreen mode before viewing questions.
  - **Tab Switch & Anti-Cheat Proctoring**: Monitors `fullscreenchange`, `visibilitychange`, and `window.blur` with a 1500ms debounce cooldown to record genuine violations. Violations are logged to database via `POST /dashboard/learning/violation/{assessmentId}` (`recordViolation`).
  - **Graduated Penalty Tolerance**: Up to 3 warning dialogs with backdrop blur lock. Exceeding tolerance (violation 4) automatically triggers submission with reason `violation_limit`.
  - **Cheating & Inspection Prevention**: Blocks DevTools shortcuts (F12, Ctrl+Shift+I/J/C, Ctrl+U, Ctrl+S, Ctrl+P), disables right-click context menu, prevents copy/cut/paste, and applies CSS `select-none`.
  - **Answer Integrity**: Question payloads exclude `is_correct` answer keys (`$query->select('id', 'course_question_id', 'answer')`), preventing inspection in browser network logs.
  - **Real-time Persistence**: Answers are saved individually via `saveAnswer()` on `StudentAnswerController` (`throttle:60,1`).
  - **Submission Confirmation**: `ExamSubmitModal.vue` displays an interactive breakdown of answered vs. unanswered questions, percentages, and contextual warning banners with full Light/Dark mode styling.
  - **Completion & Scoring**: `finishAttempt()` calculates scores based on a 50-question scale inside a database transaction (`throttle:10,1`), locking the attempt with `finished_at`.
  - **Rapport Evaluation**: Delivered via `learning_rapport()` (`Result.vue`), presenting final score, pass/fail status (KKM 70%), elapsed duration, and proctoring violation logs.

### Service Layer Pattern
- Controllers are thin and delegate domain logic and database transactions to `app/Services/`:
  - `AssessmentService`: Test attempt lifecycle, violation recording, answer persistence, score calculation, expiry checking.
  - `CourseService`: Course lifecycle and cover image storage in `storage/app/public/course_covers`.
  - `CourseQuestionService`: Question and multiple-choice answers creation/updates.
  - `StudentService`: Student listing, search filters, pagination, and suspension toggling (`is_active`).
  - `AnalyticsService`: Enrollment trends, top course performance, pass/fail ratios.
  - `DashboardService`: High-level metrics for admin dashboards.
- Database writes in services are wrapped in `DB::transaction(...)`.
- Input validation is handled via dedicated Form Requests in `app/Http/Requests/`.

### Frontend Component Structure (Atomic Design)
Components located in `resources/js/Components/` adhere to Atomic Design:
- `Atoms/`: Base components (`PrimaryButton.vue`, `TextInput.vue`, `InputLabel.vue`, `InputError.vue`, `Checkbox.vue`, `NavLink.vue`, `ApplicationLogo.vue`, `ThemeToggle.vue`).
- `Molecules/`: Composed components (`Breadcrumbs.vue`, `CountdownTimer.vue`, `DropdownLink.vue`, `Pagination.vue`).
- `Organisms/`: Complex UI blocks (`AlertDialog.vue`, `ExamSubmitModal.vue`, `ProctoringModal.vue`, `Dropdown.vue`, `Modal.vue`, `QuestionCard.vue`).
- `Templates/`: Page layout wrappers (`AdminLayout.vue`, `StudentLayout.vue`, `AuthenticatedLayout.vue`, `GuestLayout.vue`).
- Pages in `resources/js/Pages/` are organized by domain: `Admin/`, `Student/`, `Auth/`, and `Errors/`.
- Routes in Vue use Ziggy via the global `route()` helper.

### Security Hardening
- `SetSecurityHeaders` middleware applies Content Security Policy (CSP), `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, and `X-XSS-Protection`.
- Multi-tier rate limiting: `throttle:60,1` on standard web traffic, specific limits on high-frequency assessment actions.
- Universal mass-assignment protection with explicit `$fillable` attributes across all Eloquent models.
