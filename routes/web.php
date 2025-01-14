<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\DashboardController;   
use App\Models\Student;

Route::get('/', function () {
    // Redirect to student login page
    return redirect()->route('studentlogin');
});

Route::get('/studentlogin', [StudentLoginController::class, 'index'])->name('studentlogin');
Route::post('/studentlogin', [StudentLoginController::class, 'store'])->name('studentlogin.store');

// Teacher's Routes - These will be accessible only after authentication
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard route - This will be accessible to authenticated teachers
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Students Management
    Route::get('/students', function () {
        $students = Student::all();  // Fetch all students
        return Inertia::render('Students/Index', [
            'students' => $students,
        ]);
    })->name('students.index');

    Route::post('/students/create', [StudentController::class, 'store'])->name('students.store');
    Route::put('/students/{id}/update', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}/delete', [StudentController::class, 'destroy'])->name('students.destroy');

    // Sections Management
    Route::get('/sections', function () {
        $sections = App\Models\Section::all();
        return Inertia::render('Sections/Index', [
            'sections' => $sections,
        ]);
    })->name('sections.index');
    
    Route::post('/sections/create', [SectionController::class, 'store'])->name('sections.store');
    Route::put('/sections/{id}/update', [SectionController::class, 'update'])->name('sections.update');
    Route::delete('/sections/{id}/delete', [SectionController::class, 'destroy'])->name('sections.destroy');

    // Subjects Management
    Route::get('/subjects', function () {
        $subjects = App\Models\Subject::all();
        return Inertia::render('Subjects/Index', [
            'subjects' => $subjects,
        ]);
    })->name('subjects.index');

    Route::post('/subjects/create', [SubjectController::class, 'store'])->name('subjects.store');
    Route::put('/subjects/{id}/update', [SubjectController::class, 'update'])->name('subjects.update');
    Route::delete('/subjects/{id}/delete', [SubjectController::class, 'destroy'])->name('subjects.destroy');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
