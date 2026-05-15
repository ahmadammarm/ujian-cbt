<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Category;
use App\Http\Requests\Course\StoreCourseRequest;
use App\Http\Requests\Course\UpdateCourseRequest;
use App\Services\CourseService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;

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
        $courses = Course::orderBy('created_at', 'desc')->get();
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
        $this->courseService->createCourse($request->validated(), $request->file('cover'));

        return redirect()->route('dashboard.courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course): Response
    {
        $course->load('category');
        $students = $course->students()->orderBy('id', 'desc')->get();
        $questions = $course->questions()->orderBy('id', 'desc')->get();

        return Inertia::render('Admin/Courses/Manage', [
            'course' => $course,
            'students' => $students,
            'questions' => $questions
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course): Response
    {
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
        $this->courseService->updateCourse($course, $request->validated(), $request->file('cover'));

        return redirect()->route('dashboard.courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course): RedirectResponse
    {
        $this->courseService->deleteCourse($course);
        return redirect()->route('dashboard.courses.index')->with('success', 'Course deleted successfully.');
    }
}
