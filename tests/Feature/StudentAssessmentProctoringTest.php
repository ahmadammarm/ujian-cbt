<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Course;
use App\Models\StudentAssessment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class StudentAssessmentProctoringTest extends TestCase
{
    use RefreshDatabase;

    protected User $student;
    protected User $teacher;
    protected Course $course;
    protected StudentAssessment $assessment;

    protected function setUp(): void
    {
        parent::setUp();

        Role::firstOrCreate(['name' => 'student']);
        Role::firstOrCreate(['name' => 'teacher']);

        $this->teacher = User::factory()->create();
        $this->teacher->assignRole('teacher');

        $category = Category::create(['name' => 'Teknologi Informasi', 'slug' => 'teknologi-informasi']);

        $this->course = Course::create([
            'name' => 'Ujian Algoritma',
            'slug' => 'ujian-algoritma',
            'category_id' => $category->id,
            'teacher_id' => $this->teacher->id,
            'cover' => 'course_covers/default.png',
            'about' => 'Ujian deskripsi',
        ]);

        $this->student = User::factory()->create();
        $this->student->assignRole('student');
        $this->course->students()->attach($this->student->id);

        $this->assessment = StudentAssessment::create([
            'user_id' => $this->student->id,
            'course_id' => $this->course->id,
            'started_at' => now(),
            'violations_count' => 0,
            'submitted_reason' => StudentAssessment::REASON_NORMAL,
        ]);
    }

    public function test_student_can_record_violation(): void
    {
        $response = $this->actingAs($this->student)
            ->postJson(route('dashboard.learning.violation', $this->assessment->id));

        $response->assertOk()
            ->assertJson([
                'violations_count' => 1,
                'max_allowed' => StudentAssessment::MAX_VIOLATIONS_ALLOWED,
            ]);

        $this->assertDatabaseHas('student_assessments', [
            'id' => $this->assessment->id,
            'violations_count' => 1,
        ]);
    }

    public function test_other_student_cannot_record_violation_for_different_user(): void
    {
        $otherStudent = User::factory()->create();
        $otherStudent->assignRole('student');

        $response = $this->actingAs($otherStudent)
            ->postJson(route('dashboard.learning.violation', $this->assessment->id));

        $response->assertForbidden();
    }

    public function test_student_can_finish_assessment_with_violation_limit_reason(): void
    {
        $response = $this->actingAs($this->student)
            ->post(route('dashboard.learning.finish', $this->assessment->id), [
                'answers' => [],
                'violations_count' => 4,
                'submitted_reason' => StudentAssessment::REASON_VIOLATION_LIMIT,
            ]);

        $response->assertRedirect(route('dashboard.learning.report', $this->assessment->id));

        $this->assertDatabaseHas('student_assessments', [
            'id' => $this->assessment->id,
            'violations_count' => 4,
            'submitted_reason' => StudentAssessment::REASON_VIOLATION_LIMIT,
        ]);
    }
}
