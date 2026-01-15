<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;

use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
// Route::get('/home', ...); // Removed

//students route
Route::get('/students/export', [StudentController::class, 'export'])->name('students.export');
Route::get('/students', [StudentController::class,'index'])->name('students.index');
Route::get('/students/create', [StudentController::class,'create'])->name('students.create');
Route::post('/students', [StudentController::class,'store'])->name('students.store');
Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
Route::put('/students/{student}', [StudentController::class, 'update'])->name('students.update');
Route::delete('/students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');

// Subjects & Grades
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\GradeController;

Route::resource('subjects', SubjectController::class)->except(['create', 'edit', 'show']);
Route::get('/students/{student}/report', [GradeController::class, 'downloadReport'])->name('students.report');
Route::resource('grades', GradeController::class)->except(['create', 'edit', 'show']);
// Auth::routes(); // Removed as requested

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home'); // Removed
