<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::orderBy(
            'created_at',
            'desc'
        )->get();
        return view('admin.courses.index', [
            'courses' => $courses
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.courses.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'cover' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('cover')) {
                $coverPath = $request->file('cover')->store('course_covers', 'public');
                $validated['cover'] = $coverPath;
            } else {
                return redirect()->back()->withErrors(['cover' => 'Cover image is required.']);
            }

            $validated['slug'] = Str::slug($request->name);
            $newCourse = Course::create($validated);

            DB::commit();
            return redirect()->route('dashboard.courses.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $error = ValidationException::withMessages([
                'error' => 'An error occurred while creating the course: ' . $e->getMessage()
            ]);
            return redirect()->back()->withErrors($error->errors())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $categories = Category::all();
        return view('admin.courses.edit', [
            'course' => $course,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        DB::beginTransaction();

        try {
            if ($request->hasFile('cover')) {
                $coverPath = $request->file('cover')->store('course_covers', 'public');
                $validated['cover'] = $coverPath;
            } else {
                $validated['cover'] = $course->cover;
            }

            $validated['slug'] = Str::slug($request->name);
            $course->update($validated);

            DB::commit();
            return redirect()->route('dashboard.courses.index')->with('success', 'Course created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $error = ValidationException::withMessages([
                'error' => 'An error occurred while creating the course: ' . $e->getMessage()
            ]);
            return redirect()->back()->withErrors($error->errors())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        DB::beginTransaction();

        try {
            $course->delete();
            DB::commit();
            return redirect()->route('dashboard.courses.index')->with('success', 'Course deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            $error = ValidationException::withMessages([
                'error' => 'An error occurred while deleting the course: ' . $e->getMessage()
            ]);
            return redirect()->back()->withErrors($error->errors());
        }
    }
}
