<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Models\User;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Services\CourseService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function __construct(
        protected CourseService $courseService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $courses = Auth::user()->teacherCourses()
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return Inertia::render('Admin/Courses/Index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $categories = Category::all();
        return Inertia::render('Admin/Courses/Create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseRequest $request): RedirectResponse
    {
        $course = $this->courseService->createCourse($request->validated(), $request->file('cover'), Auth::user());

        if ($request->input('action') === 'add_questions') {
            return redirect()->route('dashboard.course.question.create', $course->id)->with('success', 'Kursus berhasil dibuat. Silakan tambahkan butir soal pertama.');
        }

        return redirect()->route('dashboard.courses.show', $course->id)->with('success', 'Kursus berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): Response
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $course->load('category');
        $students = $course->students()
            ->select('users.id', 'users.name', 'users.email')
            ->orderBy('id', 'desc')
            ->paginate(5, ['*'], 'students_page')
            ->withQueryString();

        $questions = $course->questions()
            ->orderBy('id', 'desc')
            ->paginate(5, ['*'], 'questions_page')
            ->withQueryString();

        $enrolledStudentIds = $course->students()->pluck('users.id')->all();
        $availableStudents = User::role('student')
            ->where('is_active', true)
            ->select('id', 'name', 'email')
            ->orderBy('name')
            ->get()
            ->map(function ($s) use ($enrolledStudentIds) {
                return [
                    'id' => $s->id,
                    'name' => $s->name,
                    'email' => $s->email,
                    'is_enrolled' => in_array($s->id, $enrolledStudentIds),
                ];
            });

        return Inertia::render('Admin/Courses/Manage', [
            'course' => $course,
            'students' => $students,
            'questions' => $questions,
            'availableStudents' => $availableStudents,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): Response
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $categories = Category::all();
        return Inertia::render('Admin/Courses/Edit', [
            'course' => $course,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseRequest $request, Course $course): RedirectResponse
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $this->courseService->updateCourse($course, $request->validated(), $request->file('cover'));

        return redirect()->route('dashboard.courses.show', $course->id)->with('success', 'Informasi kursus berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $this->courseService->deleteCourse($course);
        return redirect()->route('dashboard.courses.index')->with('success', 'Kursus berhasil dihapus.');
    }

    /**
     * Enroll selected students into the course.
     */
    public function enrollStudents(Request $request, Course $course): RedirectResponse
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validate([
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'required|integer|exists:users,id',
        ]);

        $this->courseService->enrollStudents($course, $validated['student_ids']);

        return redirect()->back()->with('success', count($validated['student_ids']) . ' peserta didik berhasil didaftarkan ke modul ini.');
    }

    /**
     * Unenroll a single student from the course.
     */
    public function unenrollStudent(Course $course, User $student): RedirectResponse
    {
        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $this->courseService->unenrollStudent($course, $student);

        return redirect()->back()->with('success', 'Peserta didik ' . $student->name . ' berhasil dikeluarkan dari modul ini.');
    }
}
