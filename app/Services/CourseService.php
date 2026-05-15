<?php

namespace App\Services;

use App\Models\Course;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CourseService
{
    /**
     * Create a new course.
     */
    public function createCourse(array $data, ?UploadedFile $cover): Course
    {
        return DB::transaction(function () use ($data, $cover) {
            if ($cover) {
                $data['cover'] = $cover->store('course_covers', 'public');
            }

            $data['slug'] = Str::slug($data['name']);
            
            return Course::create($data);
        });
    }

    /**
     * Update an existing course.
     */
    public function updateCourse(Course $course, array $data, ?UploadedFile $cover): Course
    {
        return DB::transaction(function () use ($course, $data, $cover) {
            if ($cover) {
                $data['cover'] = $cover->store('course_covers', 'public');
            } else {
                $data['cover'] = $course->cover;
            }

            $data['slug'] = Str::slug($data['name']);
            $course->update($data);

            return $course;
        });
    }

    /**
     * Delete a course.
     */
    public function deleteCourse(Course $course): bool
    {
        return $course->delete();
    }
}
