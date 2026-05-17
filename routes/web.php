<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\CourseQuestionController;
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

Route::middleware(['auth', 'verified', 'role_redirect'])->group(function () {
    Route::get('/dashboard', [LearningController::class, 'dashboard'])->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        // Teacher role routes
        Route::middleware('role:teacher')->group(function () {
            Route::get('/overview', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('overview');
            Route::get('/students-list', [\App\Http\Controllers\Admin\StudentController::class, 'index'])->name('students.index');
            Route::post('/students/{student}/toggle-suspension', [\App\Http\Controllers\Admin\StudentController::class, 'toggleSuspension'])->name('students.toggle-suspension');
            Route::get('/analytics', [\App\Http\Controllers\Admin\AnalyticsController::class, 'index'])->name('analytics');
            Route::get('/messages', fn() => Inertia::render('Admin/Messages'))->name('messages');
            Route::get('/rewards', fn() => Inertia::render('Admin/Rewards'))->name('rewards');
            Route::get('/plugins', fn() => Inertia::render('Admin/Plugins'))->name('plugins');
            Route::get('/settings', fn() => Inertia::render('Admin/Settings'))->name('settings');

            Route::resource('courses', CourseController::class);

            Route::prefix('course/question')->name('course.question.')->group(function () {
                Route::get('/create/{courseId}', [CourseQuestionController::class, 'create'])->name('create');
                Route::post('/store/{courseId}', [CourseQuestionController::class, 'store'])->name('store');
                Route::get('/edit/{courseId}/{questionId}', [CourseQuestionController::class, 'edit'])->name('edit');
                Route::put('/update/{courseId}/{questionId}', [CourseQuestionController::class, 'update'])->name('update');
                Route::delete('/delete/{courseId}/{questionId}', [CourseQuestionController::class, 'destroy'])->name('delete');
            });
        });

        // Student role routes
        Route::middleware('role:student')->group(function () {
            Route::get('/learning', [LearningController::class, 'index'])->name('learning.index');
            Route::post('/learning/start/{courseId}', [LearningController::class, 'start'])->name('learning.start');
            Route::get('/learning/{courseId}/take/{assessmentId}', [LearningController::class, 'learning'])->name('learning.course');
            Route::post('/learning/answer/{assessmentId}/{questionId}', [StudentAnswerController::class, 'store'])
                ->name('learning.answer')->middleware('throttle:60,1');
            Route::post('/learning/finish/{assessmentId}', [LearningController::class, 'finish'])
                ->name('learning.finish')->middleware('throttle:10,1');
            Route::get('/learning/result/{assessmentId}', [LearningController::class, 'learning_rapport'])->name('learning.report');
        });
    });
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
