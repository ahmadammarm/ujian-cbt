<?php

namespace App\Services;

use App\Models\Course;
use App\Models\CourseQuestion;
use Illuminate\Support\Facades\DB;

class CourseQuestionService
{
    /**
     * Create a question for a specific course.
     */
    public function createQuestionForCourse(Course $course, array $data): CourseQuestion
    {
        return DB::transaction(function () use ($course, $data) {
            $question = $course->questions()->create([
                'question' => $data['question'],
            ]);

            foreach ($data['answers'] as $index => $answerText) {
                $isCorrect = ($data['correct_answer'] == $index);
                $question->answers()->create([
                    'answer' => $answerText,
                    'is_correct' => $isCorrect,
                ]);
            }

            return $question;
        });
    }

    /**
     * Update an existing question.
     */
    public function updateQuestion(CourseQuestion $courseQuestion, array $data): CourseQuestion
    {
        return DB::transaction(function () use ($courseQuestion, $data) {
            $courseQuestion->update([
                'question' => $data['question'],
            ]);

            $courseQuestion->answers()->delete();

            foreach ($data['answers'] as $index => $answerText) {
                $isCorrect = ($data['correct_answer'] == $index);
                $courseQuestion->answers()->create([
                    'answer' => $answerText,
                    'is_correct' => $isCorrect,
                ]);
            }

            return $courseQuestion;
        });
    }
}
