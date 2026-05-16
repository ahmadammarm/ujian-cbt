<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudentAssessment;
use App\Services\AssessmentService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class LearningController extends Controller
{
    public function __construct(
        protected AssessmentService $assessmentService
    ) {}

    public function index()
    {
        $courses = Course::with('category')->withCount('questions')->get();
        $user = Auth::user();
        
        // Enrich courses with latest attempt info
        $courses->each(function($course) use ($user) {
            $course->latest_assessment = StudentAssessment::where('user_id', $user->id)
                ->where('course_id', $course->id)
                ->orderBy('created_at', 'desc')
                ->first();
        });

        return Inertia::render('Student/Courses/Index', [
            'courses' => $courses
        ]);
    }

    public function start($courseId)
    {
        $course = Course::findOrFail($courseId);
        $user = Auth::user();

        $assessment = $this->assessmentService->startAttempt($course, $user);

        return redirect()->route('dashboard.learning.course', [
            'courseId' => $course->id,
            'assessmentId' => $assessment->id
        ]);
    }

    public function learning($courseId, $assessmentId)
    {
        $course = Course::with('questions.answers')->findOrFail($courseId);
        $assessment = StudentAssessment::findOrFail($assessmentId);

        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        if ($this->assessmentService->isExpired($assessment)) {
            return $this->finish($assessment->id);
        }

        return Inertia::render('Student/Assessment/Take', [
            'course' => $course,
            'assessment' => $assessment,
            'serverTime' => now(),
        ]);
    }

    public function finish(Request $request, $assessmentId)
    {
        $assessment = StudentAssessment::findOrFail($assessmentId);

        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        $answers = $request->input('answers', []);
        $this->assessmentService->finishAttempt($assessment, $answers);

        return redirect()->route('dashboard.learning.report', ['assessmentId' => $assessment->id]);
    }

    public function learning_rapport($assessmentId)
    {
        $assessment = StudentAssessment::with(['course.category', 'answers'])->findOrFail($assessmentId);

        if ($assessment->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('Student/Assessment/Result', [
            'assessment' => $assessment
        ]);
    }
}
