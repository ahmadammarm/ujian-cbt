<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\CourseAnswer;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Ensure a student exists
        $student = User::firstOrCreate(
            ['email' => 'student@example.com'],
            [
                'name' => 'John Student',
                'password' => bcrypt('password'),
            ]
        );

        if (!$student->hasRole('student')) {
            $student->assignRole('student');
        }

        // 2. Get a category
        $category = Category::where('slug', 'programming')->first() ?? Category::first();

        // 3. Create a comprehensive CBT Course
        $course = Course::create([
            'name' => 'Laravel Advanced Mastery',
            'slug' => 'laravel-advanced-mastery',
            'category_id' => $category->id,
            'cover' => 'course_covers/default_laravel.png',
        ]);

        // 4. Enroll the student in the course
        $course->students()->attach($student->id);

        // 5. Generate exactly 50 questions
        for ($i = 1; $i <= 50; $i++) {
            $question = CourseQuestion::create([
                'course_id' => $course->id,
                'question' => "Question #{$i}: This is a sample technical question for the Laravel certification exam. What is the correct behavior of this feature?",
            ]);

            // Generate 4 answers for each question
            $correctIndex = rand(0, 3);
            for ($j = 0; $j < 4; $j++) {
                CourseAnswer::create([
                    'course_question_id' => $question->id,
                    'answer' => "Option " . chr(65 + $j) . " for question {$i}",
                    'is_correct' => ($j === $correctIndex),
                ]);
            }
        }

        $this->command->info('Course "Laravel Advanced Mastery" created with 50 questions.');
    }
}
