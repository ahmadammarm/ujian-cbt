<?php

namespace App\Http\Controllers;

use App\Models\StudentAssessment;
use App\Models\CourseQuestion;
use App\Services\AssessmentService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StudentAnswerController extends Controller
{
    public function __construct(
        protected AssessmentService $assessmentService
    ) {}

    /**
     * Store a student's answer for a specific question in an assessment.
     */
    public function store(Request $request, $assessmentId, $questionId)
    {
        $request->validate([
            'answer' => 'required|string',
        ]);

        $assessment = StudentAssessment::findOrFail($assessmentId);
        $question = CourseQuestion::findOrFail($questionId);

        try {
            $this->assessmentService->saveAnswer($assessment, $question, $request->answer);
            return back()->with('success', 'Answer saved.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
