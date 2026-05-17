<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\StudentService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StudentController extends Controller
{
    public function __construct(
        protected StudentService $studentService
    ) {}

    public function index(Request $request): Response
    {
        return Inertia::render('Admin/Students', [
            'students' => $this->studentService->getPaginatedStudents($request->input('search')),
            'filters' => $request->only(['search']),
        ]);
    }

    public function toggleSuspension(User $student)
    {
        $this->studentService->toggleSuspension($student);
        return back()->with('success', 'Student status updated successfully.');
    }
}
