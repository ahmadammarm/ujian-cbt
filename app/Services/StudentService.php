<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class StudentService
{
    /**
     * Get paginated students with course counts and average scores.
     */
    public function getPaginatedStudents(?string $search = null): LengthAwarePaginator
    {
        $query = User::role('student')
            ->withCount('courses')
            ->withAvg('assessments', 'score');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->latest()->paginate(10)->withQueryString();
    }

    /**
     * Toggle student suspension status.
     */
    public function toggleSuspension(User $user): void
    {
        $user->update([
            'is_active' => !$user->is_active
        ]);
    }
}
