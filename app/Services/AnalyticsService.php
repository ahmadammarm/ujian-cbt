<?php

namespace App\Services;

use App\Models\Course;
use App\Models\StudentAssessment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AnalyticsService
{
    /**
     * Get student enrollment trends over the last 6 months.
     */
    public function getEnrollmentTrends(): array
    {
        return User::role('student')
            ->select(DB::raw('COUNT(id) as count'), DB::raw("DATE_FORMAT(created_at, '%M %Y') as month"), DB::raw('MAX(created_at) as sort_date'))
            ->groupBy('month')
            ->orderBy('sort_date', 'asc')
            ->take(6)
            ->get()
            ->toArray();
    }

    /**
     * Get the average performance of the top 5 most enrolled courses.
     */
    public function getCoursePerformance(): array
    {
        return Course::withCount('students')
            ->withAvg('assessments', 'score')
            ->orderBy('students_count', 'desc')
            ->take(5)
            ->get()
            ->map(fn($course) => [
                'name' => $course->name,
                'enrollment_count' => $course->students_count,
                'avg_score' => round($course->assessments_avg_score ?? 0, 2)
            ])
            ->toArray();
    }

    /**
     * Get overall pass/fail ratio (Pass >= 70).
     */
    public function getPassFailRatio(): array
    {
        $total = StudentAssessment::count();
        if ($total === 0) return ['passed' => 0, 'failed' => 0];

        $passed = StudentAssessment::where('score', '>=', 70)->count();
        
        return [
            'passed' => $passed,
            'failed' => $total - $passed,
        ];
    }
}
