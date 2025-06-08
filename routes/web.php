<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseQuestionController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAnswerController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // Teacher role routes
        Route::resource('courses', CourseController::class)
            ->middleware('role:teacher');

        Route::get('/course/question/create/{courseId}', [CourseQuestionController::class, 'create'])
            ->name('course.question.create')
            ->middleware('role:teacher');

        Route::post('/course/question/store/{courseId}', [CourseQuestionController::class, 'store'])
            ->name('course.question.store')
            ->middleware('role:teacher');

        Route::resource('course_questions', CourseQuestionController::class)
            ->middleware('role:teacher')
            ->name('learning.index', 'learning');

        Route::get('/course/students/show/{courseId}', [CourseStudentController::class, 'index'])
            ->name('course.students.show')
            ->middleware('role:teacher');

        Route::get('/course/students/create/{courseId}', [CourseStudentController::class, 'create'])
            ->name('course.students.create')
            ->middleware('role:teacher');

        Route::post('/course/students/store/{courseId}', [CourseStudentController::class, 'store'])
            ->name('course.students.store')
            ->middleware('role:teacher');


        // Student role routes
        Route::get('/learning', [LearningController::class, 'index'])
            ->name('learning.index')
            ->middleware('role:student');

        Route::get('/learning/finished/{courseId}', [LearningController::class, 'learning_finished'])
            ->name('learning.finished')
            ->middleware('role:student');

        Route::get('/learning/rapport/{courseId}', [LearningController::class, 'learning_rapport'])
            ->name('learning.report')
            ->middleware('role:student');

        Route::get('/learning/{courseId}/{questionId}', [LearningController::class, 'learning'])
            ->name('learning.course')
            ->middleware('role:student');

        Route::post('/learning/answer/{courseId}/{questionId}', [StudentAnswerController::class, 'store'])
            ->name('learning.answer')
            ->middleware('role:student');
    });
});

require __DIR__ . '/auth.php';
