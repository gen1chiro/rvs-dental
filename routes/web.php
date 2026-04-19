<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\AppointmentProcedureController;
use App\Http\Controllers\ProcedureFileController;

Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/', [LoginController::class, 'authenticate'])->name('login.post');

Route::middleware(['auth', 'role'])->group(function () {
    Route::prefix('/appointments')->group(function () {
        Route::get('/calendar/data', [AppointmentController::class, 'calendar'])->name('appointments.calendar.data');
        Route::get('/{appointment}/view', [AppointmentController::class, 'view'])->name('appointments.view');
        Route::post('/{appointment}/upload', [AppointmentController::class, 'uploadProcedureImages'])->name('appointments.upload');
        Route::get('/{appointment}/generate', [AppointmentController::class, 'generate'])->name('appointments.generate');
        Route::post('/{appointment}/procedures', [AppointmentProcedureController::class, 'store'])->name('appointment.procedure.store');
        Route::post('/{appointment}/images/upload', [ProcedureFileController::class, 'save'])->name('appointments.images.save');
    });
    Route::prefix('/patients')->group(function () {
        Route::get('/search', [PatientController::class, 'search'])->name('patients.search');
    });
    Route::resource('appointments', AppointmentController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('patients', PatientController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/procedures', [ProcedureController::class, 'index']);
});
