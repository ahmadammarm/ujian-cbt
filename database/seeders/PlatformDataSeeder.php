<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Course;
use App\Models\CourseQuestion;
use App\Models\CourseAnswer;
use App\Models\StudentAssessment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PlatformDataSeeder extends Seeder
{
    /**
     * Run the database seeds to populate the platform with realistic data.
     */
    public function run(): void
    {
        $teacher = User::where('email', 'jackson@teacher.com')->first();
        if (!$teacher) {
            $this->command->error('Teacher jackson@teacher.com not found. Please run RolePermissionSeeder first.');
            return;
        }

        $categories = Category::all();
        if ($categories->isEmpty()) {
            $this->command->error('No categories found. Please run CategorySeeder first.');
            return;
        }

        // 1. Create 50 Students
        $this->command->info('Creating 50 students...');
        $students = [];
        for ($i = 1; $i <= 50; $i++) {
            $student = User::create([
                'name' => "Student " . $i,
                'email' => "student{$i}@example.com",
                'password' => bcrypt('password'),
                'is_active' => rand(1, 10) > 1, // 10% chance of being suspended
                'created_at' => Carbon::now()->subMonths(rand(0, 5))->subDays(rand(0, 28)),
            ]);
            $student->assignRole('student');
            $students[] = $student;
        }

        // 2. Create 10 Courses
        $this->command->info('Creating 10 courses...');
        $courseNames = [
            'Web Development with React', 'Mastering UI/UX Design', 'Digital Marketing 101',
            'Data Science Essentials', 'Cyber Security Fundamentals', 'Mobile App Dev with Flutter',
            'Business Analytics', 'Cloud Computing with AWS', 'Python for Beginners', 'Project Management Pro'
        ];

        foreach ($courseNames as $index => $name) {
            $course = Course::create([
                'name' => $name,
                'slug' => Str::slug($name),
                'category_id' => $categories->random()->id,
                'teacher_id' => $teacher->id,
                'cover' => 'course_covers/default.png',
                'created_at' => Carbon::now()->subMonths(6),
            ]);

            // Create some questions for the course
            for ($q = 1; $q <= 5; $q++) {
                $question = CourseQuestion::create([
                    'course_id' => $course->id,
                    'question' => "Sample Question {$q} for {$name}",
                ]);
                for ($a = 0; $a < 4; $a++) {
                    CourseAnswer::create([
                        'course_question_id' => $question->id,
                        'answer' => "Option " . chr(65 + $a),
                        'is_correct' => ($a === 0),
                    ]);
                }
            }

            // Enroll random number of students in each course
            // Make some courses more popular than others
            $enrollmentCount = ($index === 0) ? 45 : rand(10, 40);
            $randomStudents = collect($students)->random($enrollmentCount);
            
            foreach ($randomStudents as $student) {
                $course->students()->attach($student->id);

                // 70% chance the student has taken an assessment
                if (rand(1, 10) <= 7) {
                    StudentAssessment::create([
                        'user_id' => $student->id,
                        'course_id' => $course->id,
                        'score' => rand(50, 100),
                        'started_at' => Carbon::now()->subDays(rand(1, 30)),
                        'finished_at' => Carbon::now()->subDays(rand(1, 30)),
                    ]);
                }
            }
        }

        $this->command->info('Platform data seeded successfully!');
    }
}
