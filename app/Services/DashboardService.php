<?php

namespace App\Services;

use App\Models\Course;
use App\Models\StudentAssessment;
use App\Models\User;

class DashboardService
{
    /**
     * Get summary metrics for the admin dashboard.
     */
    public function getMetrics(): array
    {
        return [
            'totalStudents' => User::role('student')->count(),
            'totalCourses' => Course::count(),
            'assessmentsTaken' => StudentAssessment::count(),
        ];
    }
}
