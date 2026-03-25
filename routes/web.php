<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'authenticate'])->name('login.post');

Route::middleware('auth')->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index']);
    Route::get('/transactions', [TransactionController::class, 'index']);
    Route::get('/patients', [PatientController::class, 'index']);
});
