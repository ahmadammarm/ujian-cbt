# Backend Development Standards

## 1. Introduction
This document establishes the mandatory architectural, structural, and coding standards for all backend development within the Ujian CBT project. These standards are designed to ensure extreme maintainability, scalability, and technical rigor. AI agents must strictly adhere to every directive within this manifest.

## 2. Core Architectural Principles

### 2.1 The Triad Pattern: Request-Controller-Service
All business operations must be partitioned into three immutable layers to ensure strict separation of concerns.

#### 2.1.1 The Request Layer (Validation)
The Request layer is the first line of defense. It is solely responsible for structural integrity and data validation.
*   **Directive:** Use dedicated Laravel Form Request classes located in `app/Http/Requests`.
*   **Prohibition:** Never perform validation logic within a Controller or Service.
*   **Logic:** No business logic or database queries should reside here, except for unique constraints or existence checks via the `rules()` method.

#### 2.1.2 The Controller Layer (Orchestration)
Controllers act as the traffic controller for the application. They are the bridge between the HTTP layer and the Domain layer.
*   **Directive:** Controllers must remain "thin." Their only responsibility is to receive a validated request, invoke the appropriate Service method, and return an Inertia or JSON response.
*   **Responsibility:** Handling redirects, Flash messages, and HTTP status codes.

#### 2.1.3 The Service Layer (Business Logic)
Services encapsulate the core domain logic of the application. They are the only layer permitted to perform complex calculations, data transformations, and persistence operations.
*   **Directive:** All complex business rules must reside in `app/Services`.
*   **Dependency Injection:** Services must be injected into Controllers via the constructor to facilitate testability.

### 2.2 DRY (Don't Repeat Yourself)
*   **Standard:** If a query fragment, scoring calculation, or status check is used in more than one location, it must be abstracted into a reusable Service method or an Eloquent scope.
*   **Consistency:** Shared logic ensures that changes to business rules only need to be applied in one location.

### 2.3 Single Source of Truth
*   **Standard:** Platform-wide thresholds, durations, and status codes must be defined as class constants within the relevant Model or Service.
*   **Hardcoding:** Hardcoded magic numbers or strings are strictly prohibited.

## 3. Directory and Naming Conventions

### 3.1 Namespace Structure
*   **Controllers:** `App\Http\Controllers` (use sub-namespaces like `Admin\`, `Auth\`, `Student\`).
*   **Services:** `App\Services`.
*   **Requests:** `App\Http\Requests`.
*   **Models:** `App\Models`.

### 3.2 Naming Standards
*   **Classes:** PascalCase (e.g., `CourseQuestionController`).
*   **Methods:** camelCase (e.g., `calculateFinalScore`).
*   **Variables:** snake_case (e.g., `is_active`).
*   **Database Columns:** snake_case (e.g., `started_at`).
*   **Form Requests:** `[Action][Entity]Request` (e.g., `UpdateStudentProfileRequest`).

## 4. Implementation Standards

### 4.1 Database Transactions
*   **Mandate:** Any Service method that performs more than one write operation (Insert, Update, Delete) must be wrapped in a database transaction to ensure atomicity.
*   **Pattern:** Use `DB::transaction(function () { ... })` for consistency.

### 4.2 Eloquent Best Practices
*   **Relationships:** Always define explicit return types for relationship methods (e.g., `HasMany`, `BelongsTo`).
*   **Eager Loading:** Use `with()` to prevent N+1 query issues whenever retrieving related data.
*   **Mass Assignment:** Explicitly define `$fillable` in all models. The use of `$guarded = []` is prohibited.
*   **Soft Deletes:** Implement the `SoftDeletes` trait for all primary business entities (Courses, Questions, Assessments).

### 4.3 Error Handling and Exceptions
*   **Custom Exceptions:** Use domain-specific exceptions (e.g., `AssessmentExpiredException`) to handle business rule violations.
*   **Catching:** Only catch exceptions that you can meaningfully handle. Allow global errors to be handled by the Laravel Exception Handler.
*   **Logging:** Log all critical errors and transaction failures using the `Log` facade with appropriate context.

## 5. Security Mandates

### 5.1 Authentication and Account Status
*   **Status Check:** Every authentication attempt and sensitive operation must verify the `is_active` status of the user.
*   **Suspension:** Suspended users must be immediately prevented from accessing any authenticated route.

### 5.2 Authorization
*   **Policy:** Use Spatie permissions (`role`, `permission`) to gate access.
*   **Enforcement:** Routes must be protected via middleware. Controllers should use `$this->authorize()` for fine-grained checks.

## 6. Implementation Examples

### 6.1 The Request-Controller-Service Triad

**The Request Layer**
```php
namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->hasRole('teacher');
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'cover' => 'nullable|image|max:2048',
        ];
    }
}
```

**The Controller Layer**
```php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreCourseRequest;
use App\Services\CourseService;
use Illuminate\Http\RedirectResponse;

class CourseController extends Controller
{
    public function __construct(
        protected CourseService $courseService
    ) {}

    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $this->courseService->createCourse($request->validated(), $request->file('cover'));

        return redirect()->route('dashboard.courses.index')
            ->with('success', 'Course created successfully.');
    }
}
```

**The Service Layer**
```php
namespace App\Services;

use App\Models\Course;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseService
{
    public function createCourse(array $data, ?UploadedFile $cover): Course
    {
        return DB::transaction(function () use ($data, $cover) {
            if ($cover) {
                $data['cover'] = $cover->store('course_covers', 'public');
            }
            
            $data['slug'] = Str::slug($data['name']);
            $data['teacher_id'] = auth()->id();
            
            return Course::create($data);
        });
    }
}
```

### 6.2 The DRY Service Query Pattern

**Incorrect (Duplication)**
```php
// In CourseController
$courses = Course::withCount('students')->paginate(10);

// In AnalyticsController
$popular = Course::withCount('students')->orderBy('students_count', 'desc')->take(5)->get();
```

**Correct (DRY Service)**
```php
// app/Services/CourseService.php
class CourseService {
    public function getBaseCourseQuery() {
        return Course::withCount('students')->withAvg('assessments', 'score');
    }

    public function getPaginatedCourses() {
        return $this->getBaseCourseQuery()->paginate(10);
    }

    public function getTopEnrolledCourses(int $limit = 5) {
        return $this->getBaseCourseQuery()
            ->orderBy('students_count', 'desc')
            ->take($limit)
            ->get();
    }
}
```

## 7. Prohibitions and Anti-patterns

### 7.1 What NOT to do
*   **Inline Validation:** Never use `$request->validate()` or `Validator::make()` inside a controller.
*   **Raw DB Access in Controllers:** Never use `DB::table()` or `Course::create()` inside a controller.
*   **Raw SQL:** Never use raw SQL queries. Use Eloquent or the Query Builder to ensure parameter binding and security.
*   **Global Variables:** Never rely on global state or `$_SESSION`. Use Laravel's Request and Session abstractions.
*   **Silent Failures:** Never use empty `catch` blocks or suppress errors with `@`.
*   **Hardcoded Rules:** Never use hardcoded scores or limits (e.g., `if ($score > 70)`). Use class constants.
*   **Mass Assignment Bypassing:** Never use `$guarded = []` in any model.
*   **Logic Duplication:** Never copy-paste query logic. If a query is complex, it belongs in a Service or a Model Scope.

## 8. Conclusion
Adherence to these standards is not optional. They provide the framework for a robust, professional CBT platform. Any code that violates these patterns will be considered technical debt and must be refactored.
