<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\SubmissionController;

Route::get('/', function () {
    return view('welcome');
});



Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Attendance routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::get('/attendance/{subjectId}', [AttendanceController::class, 'show'])->name('attendance.show');
    Route::post('/attendance/{subjectId}', [AttendanceController::class, 'store'])->name('attendance.store');

    Route::get('/assignments', [AssignmentController::class, 'index'])->name('assignments.index');
    Route::get('/assignments/create/{subject}', [AssignmentController::class, 'create'])->name('assignments.create');
    Route::post('/assignments', [AssignmentController::class, 'store'])->name('assignments.store');
    Route::get('/assignments/{assignment}/submissions', [AssignmentController::class, 'viewSubmissions'])->name('assignments.submissions');
    Route::post('/submissions/{submission}/grade', [AssignmentController::class, 'gradeSubmission'])->name('submissions.grade');


    Route::get('/submissions', [SubmissionController::class, 'index'])->name('submissions.index');
    Route::get('/submissions/{assignment}/submit', [SubmissionController::class, 'submit'])->name('submissions.submit');
    Route::post('/submissions/{assignment}', [SubmissionController::class, 'store'])->name('submissions.store');
    Route::delete('/submissions/{submission}', [SubmissionController::class, 'destroy'])->name('submissions.destroy');
});
