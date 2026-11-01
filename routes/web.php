<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LecturerCourseController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentPortalController;
use App\Http\Controllers\UserAccessController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    // admin: students and courses
    Route::resource('students', StudentController::class);
    Route::resource('courses', CourseController::class);

    // admin: course registrations
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::get('/registrations/create', [RegistrationController::class, 'create'])->name('registrations.create');
    Route::post('/registrations', [RegistrationController::class, 'store'])->name('registrations.store');
    Route::delete('/registrations/{registration}', [RegistrationController::class, 'destroy'])->name('registrations.destroy');

    // admin: user access (roles)
    Route::get('/users', [UserAccessController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}', [UserAccessController::class, 'update'])->name('users.update');

    // lecturer: assigned courses and their students
    Route::get('/my-courses', [LecturerCourseController::class, 'index'])->name('lecturer.courses');
    Route::get('/my-courses/{course}', [LecturerCourseController::class, 'show'])->name('lecturer.courses.show');

    // student: available courses and own registrations
    Route::get('/available-courses', [StudentPortalController::class, 'available'])->name('portal.available');
    Route::post('/available-courses/{course}/register', [StudentPortalController::class, 'register'])->name('portal.register');
    Route::get('/my-registrations', [StudentPortalController::class, 'registrations'])->name('portal.registrations');
    Route::delete('/my-registrations/{registration}', [StudentPortalController::class, 'drop'])->name('portal.drop');
});

require __DIR__.'/auth.php';