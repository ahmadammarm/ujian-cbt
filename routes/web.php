<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseQuestionController;
use App\Http\Controllers\CourseStudentController;
use App\Http\Controllers\LearningController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentAnswerController;
use Illuminate\Support\Facades\Route;

use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::middleware('role:teacher')->group(function () {
            Route::get('/overview', function () {
                return Inertia::render('Admin/Dashboard');
            })->name('overview');

            Route::get('/students-list', function () {
                return Inertia::render('Admin/Students');
            })->name('students.index');

            Route::get('/messages', function () {
                return Inertia::render('Admin/Messages');
            })->name('messages');

            Route::get('/analytics', function () {
                return Inertia::render('Admin/Analytics');
            })->name('analytics');

            Route::get('/rewards', function () {
                return Inertia::render('Admin/Rewards');
            })->name('rewards');

            Route::get('/plugins', function () {
                return Inertia::render('Admin/Plugins');
            })->name('plugins');

            Route::get('/settings', function () {
                return Inertia::render('Admin/Settings');
            })->name('settings');

            // Teacher role resource routes
            Route::resource('courses', CourseController::class);

            // Course question management routes
            Route::get('/course/question/create/{courseId}', [CourseQuestionController::class, 'create'])
                ->name('course.question.create');

            Route::post('/course/question/store/{courseId}', [CourseQuestionController::class, 'store'])
                ->name('course.question.store');

            Route::get('/course/question/edit/{courseId}/{questionId}', [CourseQuestionController::class, 'edit'])
                ->name('course.question.edit');

            Route::put('/course/question/update/{courseId}/{questionId}', [CourseQuestionController::class, 'update'])
                ->name('course.question.update');

            Route::delete('/course/question/delete/{courseId}/{questionId}', [CourseQuestionController::class, 'destroy'])
                ->name('course.question.delete');

            Route::resource('course_questions', CourseQuestionController::class)
                ->name('learning.index', 'learning');

            Route::get('/course/students/show/{courseId}', [CourseStudentController::class, 'index'])
                ->name('course.students.show');

            Route::get('/course/students/create/{courseId}', [CourseStudentController::class, 'create'])
                ->name('course.students.create');

            Route::post('/course/students/store/{courseId}', [CourseStudentController::class, 'store'])
                ->name('course.students.store');
        });


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
