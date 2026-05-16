<?php

namespace App\Services;

use App\Models\Course;
use App\Models\StudentAssessment;
use App\Models\StudentAnswer;
use App\Models\CourseQuestion;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AssessmentService
{
    /**
     * Start a new assessment attempt.
     */
    public function startAttempt(Course $course, User $user): StudentAssessment
    {
        return StudentAssessment::create([
            'user_id' => $user->id,
            'course_id' => $course->id,
            'started_at' => now(),
        ]);
    }

    /**
     * Save a single answer for an assessment.
     */
    public function saveAnswer(StudentAssessment $assessment, CourseQuestion $question, string $answerText): StudentAnswer
    {
        return StudentAnswer::updateOrCreate(
            [
                'student_assessment_id' => $assessment->id,
                'course_question_id' => $question->id,
            ],
            [
                'user_id' => $assessment->user_id,
                'answer' => $answerText,
            ]
        );
    }

    /**
     * Calculate score and finalize the assessment with a batch of answers.
     */
    public function finishAttempt(StudentAssessment $assessment, array $answersData): StudentAssessment
    {
        return DB::transaction(function () use ($assessment, $answersData) {
            // 1. Save all answers
            foreach ($answersData as $questionId => $answerText) {
                StudentAnswer::updateOrCreate(
                    [
                        'student_assessment_id' => $assessment->id,
                        'course_question_id' => $questionId,
                    ],
                    [
                        'user_id' => $assessment->user_id,
                        'answer' => $answerText,
                    ]
                );
            }

            // 2. Calculate score
            $correctAnswersCount = 0;
            $questions = CourseQuestion::where('course_id', $assessment->course_id)->with('answers')->get();
            $totalQuestions = 50; // Per requirement

            foreach ($questions as $question) {
                $studentAnswer = StudentAnswer::where('student_assessment_id', $assessment->id)
                    ->where('course_question_id', $question->id)
                    ->first();

                if ($studentAnswer) {
                    $correctAnswer = $question->answers()->where('is_correct', true)->first();
                    if ($correctAnswer && $studentAnswer->answer === $correctAnswer->answer) {
                        $correctAnswersCount++;
                    }
                }
            }

            // Calculate score as percentage (out of 50 questions)
            $score = ($correctAnswersCount / $totalQuestions) * 100;

            $assessment->update([
                'score' => $score,
                'finished_at' => now(),
            ]);

            return $assessment;
        });
    }

    /**
     * Check if the 90-hour window has expired.
     */
    public function isExpired(StudentAssessment $assessment): bool
    {
        if (!$assessment->started_at) return false;
        if ($assessment->finished_at) return true;

        return Carbon::parse($assessment->started_at)->addHours(90)->isPast();
    }
}
