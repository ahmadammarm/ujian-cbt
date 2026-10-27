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
  - Tailwind CSS utility styling with the "study desk" design tokens and typography described below (no arbitrary inline styles or isolated custom `<style>` overrides). Light mode only.

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
  - Teacher Workspace: `Naiju Studio` (`Naiju Studio · Ruang pengajar`)
  - Student Portal: `Naiju Exam` (`Naiju Exam · Portal siswa`)
- **Audience & voice**: SMP/SMA students and their teachers. UI copy is Indonesian, sentence case, informal "kamu" for students, plain verbs, no emoji.
- **Emblem**: Geometric 'N' monogram vector (`ApplicationLogo.vue`)

### Design System: "Study Desk"
The whole app (landing, auth, student portal, exam, teacher workspace) uses one visual language drawn from an Indonesian school notebook and the LJK answer sheet. **Light mode only — there is no dark mode.** Tokens live in `tailwind.config.js`; never use raw hex values in templates.

| Token | Hex | Use |
|---|---|---|
| `desk` | `#EEF2F8` | App background (dashboards, exam) |
| `paper` | `#FBFCFE` | Cards, sheets, landing/auth background |
| `rule` | `#CFE0F3` | Borders, dividers, notebook lines (`bg-notebook-lines`) |
| `ink` / `ink-soft` | `#1B2A6B` / `#4A5683` | Text, primary actions / secondary text |
| `ink-mark` | `#3D53A6` | Chart fills only (validated with `pen` for colour-blind separation) |
| `pen` | `#C8323F` | Printed LJK labels, scores, errors, violations, destructive actions |
| `graphite` | `#34353B` | 2B-pencil fills (answered bubbles), sticky-note text |
| `stabilo` | `#FFE45E` | Active/selected state, focus highlight on fields, warnings |
| `sticky` | `#FFF1A6` | Sticky notes and flash notifications |

- **Typography**: `font-hand` (Shantell Sans) for page titles (h1) and handwritten accents only; `font-legible` / default `sans` (Atkinson Hyperlegible) for body, tables, and forms; `font-form` (IBM Plex Mono) for small uppercase labels, numbers, and timers.
- **Structural motifs**: a red notebook margin line (`border-pen/40`) separates the sidebar from content; LJK sheet headers are a mono `pen` label over `border-b-2 border-pen`; the active nav item / selected answer is highlighted in `stabilo`.
- **Signature elements**: scores are always rendered with `ScoreMark` (red-pen circled number); violations with `TallyMarks`; answer choices with `BubbleMark` (pencil-filled LJK bubble).
- **Charts**: colours come from `resources/js/Utils/chartTheme.js` (mirrors the tokens). Validate any new chart palette with the dataviz palette validator before use.
- **Shared constants**: the pass mark (`PASSING_SCORE = 70`) and date helpers live in `resources/js/Utils/exam.js`; never hardcode `70` in a component.

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
  - **Answer Persistence**: `Take.vue` keeps answers, current question index, violation count, and the started flag in `localStorage` (`assessment_progress_{id}`, `assessment_index_{id}`, `assessment_violations_{id}`, `assessment_started_{id}`) and sends all answers on submit. The per-answer route (`StudentAnswerController::store`, `throttle:60,1`) exists but is not called by the frontend.
  - **Single Submission**: `submitExam()` returns early while a submission is in flight, so timeout, violation limit, and manual submit cannot post twice. Only one `CountdownTimer` is mounted.
  - **Submission Confirmation**: `ExamSubmitModal.vue` shows answered vs. unanswered counts and percentage, with a warning when questions are still empty.
  - **Completion & Scoring**: `finishAttempt()` scores `correct / total questions × 100` (falls back to 50 only when a course has no questions) inside a database transaction (`throttle:10,1`), setting `finished_at`.
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
- `Atoms/`: `InkButton` (primary; link or submit button, `variant` ink/danger), `GhostButton` (secondary outline), `PenLink` (underlined text link), `Icon` (all inline SVG icons by name — do not use image icons), `NavItem`, `BubbleMark`, `AnswerBubble`, `ScoreMark`, `TallyMarks`, `StatusBadge`, `FormStatus`, `StickyNote`, `Highlighter`, `Checkbox`, `CourseThumbnail`, `ApplicationLogo`.
- `Molecules/`: `PageHeader` (eyebrow + handwritten h1 + description + actions), `EmptyState`, `MetricCard`, `SearchBar`, form fields `NotebookField` / `NotebookSelect` / `NotebookTextarea` / `CoverUpload`, `FlashNote` (renders shared `flash` props), `CountdownTimer`, `Breadcrumbs`, `Pagination`, `DropdownLink`.
- `Organisms/`: `QuestionCard`, `ProctoringModal`, `ExamSubmitModal`, `CourseForm`, `QuestionForm`, `CourseRow`, `StudentRow`, `AlertDialog`, `Modal`, `Dropdown`, `ErrorSheet`, and the `Landing*` sections.
- `Templates/`: `AppShell` (sidebar + mobile drawer shared by the dashboards), `StudentLayout` and `AdminLayout` (thin `AppShell` wrappers that only define nav items), `GuestLayout` (auth pages), `LandingLayout`.
- Pages in `resources/js/Pages/` are organized by domain: `Admin/`, `Student/`, `Auth/`, `Profile/` (rendered in `AdminLayout` or `StudentLayout` by `auth.user.role`), and `Errors/`.
- Shared Inertia props (`HandleInertiaRequests`): `auth.user` (`id`, `name`, `email`, `role`) and `flash` (`success`, `error`).
- Routes in Vue use Ziggy via the global `route()` helper.

### Security Hardening
- `SetSecurityHeaders` middleware applies Content Security Policy (CSP), `X-Frame-Options: SAMEORIGIN`, `X-Content-Type-Options: nosniff`, and `X-XSS-Protection`.
- Multi-tier rate limiting: `throttle:60,1` on standard web traffic, specific limits on high-frequency assessment actions.
- Universal mass-assignment protection with explicit `$fillable` attributes across all Eloquent models.
