<?php

namespace App\Http\Controllers;

use App\Models\CourseQuestion;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($courseId)
    {
        $course = Course::where('id', $courseId)->first();
        $students = $course->students()->orderBy('id', 'desc')->get();
        $questions = $course->questions()->orderBy('id', 'desc')->get();
        
        return view('admin.questions.create', [
            'course' => $course,
            'students' => $students,
            'questions' => $questions
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $courseId)
    {
        $course = Course::where('id', $courseId)->first();
        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array|min:4',
            'answers.*' => 'required|string',
            'correct_answer' => 'required|integer',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $course) {
            $question = $course->questions()->create([
                'question' => $request->question,
            ]);

            foreach ($request->answers as $index => $answerText) {
                $isCorrect = ($request->correct_answer == $index);
                $question->answers()->create([
                    'answer' => $answerText,
                    'is_correct' => $isCorrect,
                ]);
            }
        });

        return redirect()->route('dashboard.courses.show', $courseId);
    }

    /**
     * Display the specified resource.
     */
    public function show(CourseQuestion $courseQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($courseId, $questionId)
    {
        $course = Course::findOrFail($courseId);
        $courseQuestion = CourseQuestion::with('answers')->findOrFail($questionId);

        return view('admin.questions.edit', compact('course', 'courseQuestion'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $courseId, $questionId)
    {
        $courseQuestion = CourseQuestion::findOrFail($questionId);

        $validated = $request->validate([
            'question' => 'required|string|max:255',
            'answers' => 'required|array|min:4',
            'answers.*' => 'required|string',
            'correct_answer' => 'required|integer',
        ]);

        \Illuminate\Support\Facades\DB::transaction(function () use ($request, $courseQuestion) {
            $courseQuestion->update([
                'question' => $request->question,
            ]);

            $courseQuestion->answers()->delete();

            foreach ($request->answers as $index => $answerText) {
                $isCorrect = ($request->correct_answer == $index);
                $courseQuestion->answers()->create([
                    'answer' => $answerText,
                    'is_correct' => $isCorrect,
                ]);
            }
        });

        return redirect()->route('dashboard.courses.show', $courseId);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($courseId, $questionId)
    {
        try {
            $courseQuestion = CourseQuestion::findOrFail($questionId);
            $courseQuestion->delete();
            return redirect()->route('dashboard.courses.show', $courseId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to delete question.');
        }
    }
}
