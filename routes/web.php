<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate'])->name('login.post');

// TODO: MAKE MIDDLEWARE CHECK ROLE!!!
Route::middleware('auth')->group(function () {
    Route::get('/appointments/calendar/data', [AppointmentController::class, 'calendar'])->name('appointments.calendar.data');
    Route::resource('appointments', AppointmentController::class);
    Route::resource('transactions',TransactionController::class);
    Route::resource('patients', PatientController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/certificate', [PatientController::class, 'certificate']);
});
