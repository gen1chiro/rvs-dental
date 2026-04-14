<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate'])->name('login.post');

Route::middleware(['auth', 'role'])->group(function () {
    Route::prefix('/appointments')->group(function () {
        Route::get('/calendar/data', [AppointmentController::class, 'calendar'])->name('appointments.calendar.data');
        Route::get('/{appointment}/view', [AppointmentController::class, 'view'])->name('appointments.view');
    });
    Route::prefix('/patients')->group(function() {
        Route::get('/certificate', [PatientController::class, 'certificate']);
        Route::get('/search', [PatientController::class, 'search'])->name('patients.search');
    });
    Route::resource('appointments', AppointmentController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('patients', PatientController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
