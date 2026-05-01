<?php

use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProcedureController;
use App\Http\Controllers\AppointmentProcedureController;
use App\Http\Controllers\ProcedureFileController;
use App\Http\Controllers\DentalCertificateController;

Route::middleware('logged_in')->group(function () {
    Route::get('/', [LoginController::class, 'index'])->name('login');
    Route::post('/', [LoginController::class, 'authenticate'])->name('login.post');
});

Route::middleware(['auth', 'role'])->group(function () {
    Route::prefix('/appointments')->group(function () {
        Route::get('/calendar/data', [AppointmentController::class, 'calendar'])->name('appointments.calendar.data');
        Route::get('/{appointment}/view', [AppointmentController::class, 'view'])->name('appointments.view');
        Route::get('/{appointment}/medical-form', [AppointmentController::class, 'medicalForm'])->name('appointments.medical-form');
        Route::get('/{appointment}/generate', [AppointmentController::class, 'generate'])->name('appointments.generate');
        Route::get('/{appointment}/full', [AppointmentController::class, 'fullDetails'])->name('appointments.full');
        Route::post('/{appointment}/medical-form', [AppointmentController::class, 'storeMedicalForm'])->name('appointments.medical-form.store');
        Route::post('/{appointment}/upload', [AppointmentController::class, 'uploadProcedureImages'])->name('appointments.upload');
        Route::post('/{appointment}/procedures', [AppointmentProcedureController::class, 'store'])->name('appointment.procedure.store');
        Route::post('/{appointment}/images/upload', [ProcedureFileController::class, 'save'])->name('appointments.images.save');
    });
        
    Route::prefix('/patients')->group(function () {
        Route::get('/search', [PatientController::class, 'search'])->name('patients.search');
        Route::get('/{patient}/appointments', [AppointmentController::class, 'forPatient'])->name('appointments.for-patient');
        Route::get('/{patient}/summary', [PatientController::class, 'summary'])->name('patient.summary');
    });

    Route::get('/procedures', [ProcedureController::class, 'index']);
    Route::resource('appointments', AppointmentController::class);
    Route::resource('transactions', TransactionController::class)
        ->parameters(['transactions' => 'ledger'])
        ->except(['update']);
    Route::put('/transactions/{transaction}', [TransactionController::class, 'update']);
    Route::resource('patients', PatientController::class);
    Route::resource('dental-certificates', DentalCertificateController::class);
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
