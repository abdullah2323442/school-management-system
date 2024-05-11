<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AttendanceController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/attendance/{subjectId}', [AttendanceController::class, 'index'])->name('attendance.index');
Route::post('/attendance/{subjectId}', [AttendanceController::class, 'store'])->name('attendance.store');


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
