<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EnrollmentController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\DashboardController;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', StudentController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('enrollments', EnrollmentController::class);
    Route::resource('grades', GradeController::class);

    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/grades', [GradeController::class, 'index'])->name('grades.index');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/enrollments', [EnrollmentController::class, 'index'])->name('enrollments.index');
});


// User routes (protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/my-profile', [UserController::class, 'profile'])->name('student.profile');
    Route::get('/my-enrollments', [UserController::class, 'enrollments'])->name('student.enrollments');
    Route::get('/my-grades', [UserController::class, 'grades'])->name('student.grades');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
