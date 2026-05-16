<?php

namespace App\Http\Controllers;

use App\Models\CourseQuestion;
use App\Models\Course;
use App\Http\Requests\CourseQuestion\StoreCourseQuestionRequest;
use App\Http\Requests\CourseQuestion\UpdateCourseQuestionRequest;
use App\Services\CourseQuestionService;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class CourseQuestionController extends Controller
{
    public function __construct(
        protected CourseQuestionService $courseQuestionService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($courseId): Response
    {
        $course = Course::findOrFail($courseId);

        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }
        
        return Inertia::render('Admin/Questions/Create', [
            'course' => $course,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCourseQuestionRequest $request, $courseId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);

        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $this->courseQuestionService->createQuestionForCourse($course, $request->validated());

        return redirect()->route('dashboard.courses.show', $courseId);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($courseId, $questionId): Response
    {
        $course = Course::findOrFail($courseId);
        $courseQuestion = CourseQuestion::with('answers')
            ->where('course_id', $courseId)
            ->findOrFail($questionId);

        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('Admin/Questions/Edit', [
            'course' => $course,
            'courseQuestion' => $courseQuestion
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCourseQuestionRequest $request, $courseId, $questionId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);
        $courseQuestion = CourseQuestion::where('course_id', $courseId)
            ->findOrFail($questionId);

        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $this->courseQuestionService->updateQuestion($courseQuestion, $request->validated());

        return redirect()->route('dashboard.courses.show', $courseId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId, $questionId): RedirectResponse
    {
        $course = Course::findOrFail($courseId);
        $courseQuestion = CourseQuestion::where('course_id', $courseId)
            ->findOrFail($questionId);

        if ($course->teacher_id !== Auth::id()) {
            abort(403);
        }

        $courseQuestion->delete();
        
        return redirect()->route('dashboard.courses.show', $courseId);
    }
}
