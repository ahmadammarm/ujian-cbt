<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\FinishAssessmentRequest;
use App\Models\Course;
use App\Models\StudentAssessment;
use App\Services\AssessmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class LearningController extends Controller
{
    public function __construct(
        protected AssessmentService $assessmentService
    ) {}

    public function dashboard(): Response
    {
        $user = Auth::user();
        $courses = $user->courses()->with('category')->withCount('questions')->get();
        $assessments = StudentAssessment::where('user_id', $user->id)
            ->with('course')
            ->orderBy('created_at', 'desc')
            ->get();

        return Inertia::render('Student/Dashboard', [
            'courses' => $courses,
            'assessments' => $assessments,
        ]);
    }

    public function index(): Response
    {
        $user = Auth::user();
        $courses = $user->courses()->with('category')->withCount('questions')->get();

        // Enrich courses with latest attempt info
        $courses->each(function ($course) use ($user) {
            $course->latest_assessment = StudentAssessment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->orderBy('created_at', 'desc')
                ->first();
        });

        return Inertia::render('Student/Courses/Index', [
            'courses' => $courses,
        ]);
    }

    public function start($courseId): RedirectResponse
    {
        $user = Auth::user();

        if (! $user->courses()->where('course_id', $courseId)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $course = Course::findOrFail($courseId);
        $assessment = $this->assessmentService->startAttempt($course, $user);

        return redirect()->route('dashboard.learning.course', [
            'courseId' => $course->id,
            'assessmentId' => $assessment->id,
        ]);
    }

    public function learning($courseId, $assessmentId): Response|RedirectResponse
    {
        $user = Auth::user();

        if (! $user->courses()->where('course_id', $courseId)->exists()) {
            abort(403, 'You are not enrolled in this course.');
        }

        $course = Course::with(['questions.answers' => function ($query) {
            $query->select('id', 'course_question_id', 'answer'); // Exclude is_correct
        }])->findOrFail($courseId);
        $assessment = StudentAssessment::findOrFail($assessmentId);

        if ($assessment->user_id !== $user->id) {
            abort(403);
        }

        if ($this->assessmentService->isExpired($assessment)) {
            $this->assessmentService->finishAttempt($assessment, [], 0, StudentAssessment::REASON_TIMEOUT);

            return redirect()->route('dashboard.learning.report', ['assessmentId' => $assessment->id]);
        }

        return Inertia::render('Student/Assessment/Take', [
            'course' => $course,
            'assessment' => $assessment,
            'serverTime' => now(),
            'maxViolationsAllowed' => StudentAssessment::MAX_VIOLATIONS_ALLOWED,
        ]);
    }

    public function recordViolation($assessmentId): JsonResponse
    {
        $assessment = StudentAssessment::findOrFail($assessmentId);

        if ($assessment->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $count = $this->assessmentService->recordViolation($assessment);

        return response()->json([
            'violations_count' => $count,
            'max_allowed' => StudentAssessment::MAX_VIOLATIONS_ALLOWED,
        ]);
    }

    public function finish(FinishAssessmentRequest $request, $assessmentId): RedirectResponse
    {
        $assessment = StudentAssessment::findOrFail($assessmentId);

        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        $validated = $request->validated();
        $answers = $validated['answers'] ?? [];
        $violationsCount = (int) ($validated['violations_count'] ?? 0);
        $submittedReason = $validated['submitted_reason'] ?? StudentAssessment::REASON_NORMAL;

        $this->assessmentService->finishAttempt($assessment, $answers, $violationsCount, $submittedReason);

        return redirect()->route('dashboard.learning.report', ['assessmentId' => $assessment->id]);
    }

    public function learning_rapport($assessmentId): Response
    {
        $assessment = StudentAssessment::with(['course.category', 'answers'])->findOrFail($assessmentId);

        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('Student/Assessment/Result', [
            'assessment' => $assessment,
        ]);
    }
}
